<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryCategoryRequest;
use App\Models\GalleryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryCategoryController extends Controller
{
    public function index(): View
    {
        $categories = GalleryCategory::withCount('galleries')->ordered()->paginate(10);

        return view('admin.gallery-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.gallery-categories.create');
    }

    public function store(GalleryCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['name']);

        GalleryCategory::create($data);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category created successfully.');
    }

    public function edit(GalleryCategory $galleryCategory): View
    {
        return view('admin.gallery-categories.edit', compact('galleryCategory'));
    }

    public function update(GalleryCategoryRequest $request, GalleryCategory $galleryCategory): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['name'], $galleryCategory->id);

        $galleryCategory->update($data);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category updated successfully.');
    }

    public function destroy(GalleryCategory $galleryCategory): RedirectResponse
    {
        if ($galleryCategory->galleries()->exists()) {
            return back()->with('error', 'This category has gallery images and cannot be deleted.');
        }

        $galleryCategory->delete();

        return back()->with('success', 'Gallery category deleted successfully.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 2;

        while (GalleryCategory::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
