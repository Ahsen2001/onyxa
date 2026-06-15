<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
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
        $galleries = Gallery::query()
            ->with('category')
            ->when($request->filled('category'), fn ($query) => $query->where('gallery_category_id', '=', $request->integer('category'), 'and'))
            ->latest('updated_at')
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    public function create(): View
    {
        $categories = GalleryCategory::active()->ordered()->get();

        return view('admin.galleries.create', compact('categories'));
    }

    public function store(GalleryRequest $request): RedirectResponse
    {
        $data = $request->validated();
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

    public function update(GalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validated();
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
        Gallery::destroy($gallery->getKey());

        return back()->with('success', 'Gallery image deleted successfully.');
    }

    public function updateStatus(Request $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $gallery->update(['status' => $data['status']]);

        return back()->with('success', 'Gallery image status updated successfully.');
    }

}
