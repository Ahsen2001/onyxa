<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Support\MediaLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $media = Media::query()
            ->with('uploader')
            ->images()
            ->search($request->string('search')->toString())
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('admin.media.index', [
            'media' => $media,
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'images' => ['required', 'array', 'max:20'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'alt_text' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
        ]);

        foreach ($data['images'] as $image) {
            MediaLibrary::store($image, $request->user()->id, $data['alt_text'] ?? null);
        }

        return back()->with('success', 'Images uploaded to the Media Library.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        if (MediaLibrary::isUsed($media)) {
            return back()->with('error', 'This image is currently used and cannot be deleted.');
        }

        Storage::disk('public')->delete($media->file_path);
        $media->delete();

        return back()->with('success', 'Unused image deleted successfully.');
    }
}
