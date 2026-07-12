<div class="grid gap-5">
    <div>
        <label class="mb-2 block text-sm font-semibold">Title</label>
        <input name="title" value="{{ old('title', $event?->title) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        <p class="mt-2 text-xs text-[#6F665A]">Slug is generated automatically from the title.</p>
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold">Description</label>
        <textarea name="description" rows="9" required data-ckeditor data-upload-url="{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('description', $event?->description) }}</textarea>
    </div>
    <div class="grid gap-5 md:grid-cols-4">
        <div><label class="mb-2 block text-sm font-semibold">Date</label><input type="date" name="event_date" value="{{ old('event_date', $event?->event_date?->format('Y-m-d')) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3"></div>
        <div><label class="mb-2 block text-sm font-semibold">Time</label><input type="time" name="event_time" value="{{ old('event_time', $event?->event_time ? substr($event->event_time, 0, 5) : null) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3"></div>
        <div><label class="mb-2 block text-sm font-semibold">Location</label><input name="location" value="{{ old('location', $event?->location) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3"></div>
        <div><label class="mb-2 block text-sm font-semibold">Status</label><select name="status" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">@foreach(['upcoming'=>'Upcoming','completed'=>'Completed','cancelled'=>'Cancelled'] as $value=>$label)<option value="{{ $value }}" @selected(old('status', $event?->status ?? 'upcoming') === $value)>{{ $label }}</option>@endforeach</select></div>
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold">Featured Image</label>
        <x-ui.media-picker name="featured_image_media_id" label="Select Featured Image from Media Library" :current-path="$event?->featured_image" :media-items="$mediaItems ?? collect()" />
        <input type="file" name="featured_image" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
        <p class="mt-2 text-xs text-[#6F665A]">Uploading a new file will add it to the Media Library.</p>
        @if ($event?->featured_image)<img src="{{ asset('storage/'.$event->featured_image) }}" alt="{{ $event->title }}" class="mt-3 h-32 w-48 rounded-lg object-cover">@endif
    </div>
    <div class="flex flex-wrap gap-3">
        <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Save Event</button>
        <a href="{{ route('admin.events.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Cancel</a>
    </div>
</div>
