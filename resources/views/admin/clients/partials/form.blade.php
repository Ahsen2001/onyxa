<div class="grid gap-5">
    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Company Name</label>
            <input name="company_name" value="{{ old('company_name', $client?->company_name) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Website URL</label>
            <input type="url" name="website_url" value="{{ old('website_url', $client?->website_url) }}" placeholder="https://example.com" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Display Order</label>
            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $client?->sort_order ?? 0) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Status</label>
            <select name="status" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                @foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $client?->status ?? 'active') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Client Logo</label>
            <x-ui.media-picker name="logo_media_id" label="Select Logo from Media Library" :current-path="$client?->logo" :media-items="$mediaItems ?? collect()" />
            <input type="file" name="logo" accept="image/*" class="mt-3 w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
            <p class="mt-2 text-xs text-[#6F665A]">Uploading a new logo will add it to the Media Library. PNG or WebP logos with transparent backgrounds work best.</p>
        </div>
        @if ($client?->logo)
            <div>
                <p class="mb-2 text-sm font-semibold">Current Logo</p>
                <div class="grid min-h-32 place-items-center rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-5">
                    <img src="{{ asset('storage/'.$client->logo) }}" alt="{{ $client->company_name }}" class="max-h-24 max-w-full object-contain">
                </div>
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-3">
        <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Save Client</button>
        <a href="{{ route('admin.clients.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Cancel</a>
    </div>
</div>
