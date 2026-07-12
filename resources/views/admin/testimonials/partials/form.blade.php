<div class="grid gap-5">
    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Customer Name</label>
            <input name="customer_name" value="{{ old('customer_name', $testimonial?->customer_name) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Company Name</label>
            <input name="company_name" value="{{ old('company_name', $testimonial?->company_name) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label class="mb-2 block text-sm font-semibold">Position</label>
            <input name="position" value="{{ old('position', $testimonial?->position) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Rating</label>
            <select name="rating" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                @foreach ([5, 4, 3, 2, 1] as $rating)
                    <option value="{{ $rating }}" @selected((int) old('rating', $testimonial?->rating ?? 5) === $rating)>{{ $rating }} stars</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Status</label>
            <select name="status" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                @foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $testimonial?->status ?? 'active') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Message</label>
        <textarea name="message" rows="6" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('message', $testimonial?->message) }}</textarea>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Customer Image</label>
            <x-ui.media-picker name="image_media_id" label="Select Image from Media Library" :current-path="$testimonial?->image" :media-items="$mediaItems ?? collect()" />
            <input type="file" name="image" accept="image/*" class="mt-3 w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
            <p class="mt-2 text-xs text-[#6F665A]">Uploading a new image will add it to the Media Library.</p>
        </div>
        @if ($testimonial?->image)
            <div>
                <p class="mb-2 text-sm font-semibold">Current Image</p>
                <img src="{{ asset('storage/'.$testimonial->image) }}" alt="{{ $testimonial->customer_name }}" class="h-32 w-32 rounded-full object-cover">
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-3">
        <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Save Testimonial</button>
        <a href="{{ route('admin.testimonials.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Cancel</a>
    </div>
</div>
