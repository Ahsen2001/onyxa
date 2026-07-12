<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use App\Models\Media;
use App\Support\HtmlSanitizer;
use App\Support\MediaLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with('user')
            ->orderByRaw("FIELD(status, 'upcoming', 'completed', 'cancelled')")
            ->orderBy('event_date', 'asc')
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        $mediaItems = Media::images()->latest()->take(80)->get();

        return view('admin.events.create', compact('mediaItems'));
    }

    public function store(EventRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['user_id'] = $request->user()->id;
        $data['description'] = HtmlSanitizer::clean($data['description']);
        $data['featured_image'] = MediaLibrary::imagePathFromRequest($request->input('featured_image_media_id')) ?? ($data['featured_image'] ?? null);
        unset($data['featured_image_media_id']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = MediaLibrary::store($request->file('featured_image'), $request->user()->id, $data['title'], 'events')->file_path;
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event): View
    {
        $event->load('user');

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $mediaItems = Media::images()->latest()->take(80)->get();

        return view('admin.events.edit', compact('event', 'mediaItems'));
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['title'], $event->id);
        $data['description'] = HtmlSanitizer::clean($data['description']);
        $selectedImage = MediaLibrary::imagePathFromRequest($request->input('featured_image_media_id'));
        unset($data['featured_image_media_id']);

        if ($selectedImage) {
            $this->deleteImage($event->featured_image);
            $data['featured_image'] = $selectedImage;
        }

        if ($request->hasFile('featured_image')) {
            $this->deleteImage($event->featured_image);
            $data['featured_image'] = MediaLibrary::store($request->file('featured_image'), $request->user()->id, $data['title'], 'events')->file_path;
        }

        $event->update($data);

        return redirect()->route('admin.events.edit', $event)->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->deleteImage($event->featured_image);
        Event::destroy($event->getKey());

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    public function updateStatus(Request $request, Event $event): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:upcoming,completed,cancelled'],
        ]);

        $event->update(['status' => $data['status']]);

        return back()->with('success', 'Event status updated successfully.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (Event::query()->where('slug', '=', $slug, 'and')->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function deleteImage(?string $path): void
    {
        MediaLibrary::deleteIfUntracked($path);
    }
}
