<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = GalleryCategory::ordered()->get();
        $galleries = Gallery::with('category')
            ->when($request->filled('category'), fn ($query) => $query->where('gallery_category_id', $request->integer('category')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    public function create(): View
    {
        $categories = GalleryCategory::active()->ordered()->get();

        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, true);
        $data['image'] = $request->file('image')->store('gallery', 'public');
        $data['alt_text'] = $data['title'] ?? 'ONYXA gallery image';

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery image uploaded successfully.');
    }

    public function edit(Gallery $gallery): View
    {
        $categories = GalleryCategory::active()->ordered()->get();

        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['alt_text'] = $data['title'] ?? 'ONYXA gallery image';

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Gallery image deleted successfully.');
    }

    private function validatedData(Request $request, bool $imageRequired = false): array
    {
        return $request->validate([
            'gallery_category_id' => ['nullable', 'exists:gallery_categories,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }
}
