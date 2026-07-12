<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoMetaRequest;
use App\Models\SeoMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SeoMetaController extends Controller
{
    public function index(): View
    {
        $seoMeta = SeoMeta::query()
            ->orderBy('page_type')
            ->orderBy('page_id')
            ->paginate(12);

        return view('admin.seo-meta.index', compact('seoMeta'));
    }

    public function create(): View
    {
        return view('admin.seo-meta.create', [
            'seoMeta' => null,
            'pageTypes' => SeoMeta::pageTypes(),
        ]);
    }

    public function store(SeoMetaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        SeoMeta::create($data);

        return redirect()->route('admin.seo-meta.index')->with('success', 'SEO meta created successfully.');
    }

    public function edit(SeoMeta $seoMeta): View
    {
        return view('admin.seo-meta.edit', [
            'seoMeta' => $seoMeta,
            'pageTypes' => SeoMeta::pageTypes(),
        ]);
    }

    public function update(SeoMetaRequest $request, SeoMeta $seoMeta): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('og_image')) {
            $this->deleteImage($seoMeta->og_image);
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $seoMeta->update($data);

        return redirect()->route('admin.seo-meta.edit', $seoMeta)->with('success', 'SEO meta updated successfully.');
    }

    public function destroy(SeoMeta $seoMeta): RedirectResponse
    {
        $this->deleteImage($seoMeta->og_image);
        $seoMeta->delete();

        return redirect()->route('admin.seo-meta.index')->with('success', 'SEO meta deleted successfully.');
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
