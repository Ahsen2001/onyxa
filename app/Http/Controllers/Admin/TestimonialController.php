<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Media;
use App\Models\Testimonial;
use App\Support\MediaLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::query()
            ->latest()
            ->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        $mediaItems = Media::images()->latest()->take(80)->get();

        return view('admin.testimonials.create', [
            'testimonial' => null,
            'mediaItems' => $mediaItems,
        ]);
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['image'] = MediaLibrary::imagePathFromRequest($request->input('image_media_id')) ?? ($data['image'] ?? null);
        unset($data['image_media_id']);

        if ($request->hasFile('image')) {
            $data['image'] = MediaLibrary::store($request->file('image'), $request->user()->id, $data['customer_name'], 'testimonials')->file_path;
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial): View
    {
        $mediaItems = Media::images()->latest()->take(80)->get();

        return view('admin.testimonials.edit', compact('testimonial', 'mediaItems'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();
        $selectedImage = MediaLibrary::imagePathFromRequest($request->input('image_media_id'));
        unset($data['image_media_id']);

        if ($selectedImage) {
            MediaLibrary::deleteIfUntracked($testimonial->image);
            $data['image'] = $selectedImage;
        }

        if ($request->hasFile('image')) {
            MediaLibrary::deleteIfUntracked($testimonial->image);
            $data['image'] = MediaLibrary::store($request->file('image'), $request->user()->id, $data['customer_name'], 'testimonials')->file_path;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.edit', $testimonial)->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        MediaLibrary::deleteIfUntracked($testimonial->image);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }

    public function updateStatus(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $testimonial->update(['status' => $data['status']]);

        return back()->with('success', 'Testimonial status updated successfully.');
    }
}
