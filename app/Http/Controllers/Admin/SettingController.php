<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit');
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach (['logo', 'favicon'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $oldPath = Setting::valueFor($imageKey);
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
                $data[$imageKey] = $request->file($imageKey)->store('settings', 'public');
            }
        }

        foreach ($data as $key => $value) {
            $type = in_array($key, ['logo', 'favicon'], true) ? 'image' : (str_ends_with($key, '_url') ? 'url' : 'text');
            Setting::setValue($key, $value, $type, $this->groupFor($key));
        }

        cache()->flush();

        return back()->with('success', 'Website settings updated successfully.');
    }

    private function groupFor(string $key): string
    {
        return match (true) {
            in_array($key, ['facebook_url', 'instagram_url', 'linkedin_url', 'youtube_url'], true) => 'social',
            in_array($key, ['email', 'phone', 'whatsapp', 'address', 'business_hours', 'google_map_embed'], true) => 'contact',
            default => 'company',
        };
    }
}
