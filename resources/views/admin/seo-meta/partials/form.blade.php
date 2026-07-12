<div class="grid gap-5">
    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label class="mb-2 block text-sm font-semibold">Page Type</label>
            <select name="page_type" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                <option value="">Select page type</option>
                @foreach ($pageTypes as $value => $label)
                    <option value="{{ $value }}" @selected(old('page_type', $seoMeta?->page_type) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Page ID</label>
            <input type="number" name="page_id" min="1" value="{{ old('page_id', $seoMeta?->page_id) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
            <p class="mt-2 text-xs text-[#6F665A]">Required for product_detail, news_detail, and event_detail only.</p>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Robots Meta</label>
            <select name="robots" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                @foreach (['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'] as $robots)
                    <option value="{{ $robots }}" @selected(old('robots', $seoMeta?->robots ?? 'index, follow') === $robots)>{{ $robots }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Meta Title</label>
            <input name="meta_title" value="{{ old('meta_title', $seoMeta?->meta_title) }}" maxlength="255" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">OG Title</label>
            <input name="og_title" value="{{ old('og_title', $seoMeta?->og_title) }}" maxlength="255" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Meta Description</label>
            <textarea name="meta_description" rows="4" maxlength="500" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('meta_description', $seoMeta?->meta_description) }}</textarea>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">OG Description</label>
            <textarea name="og_description" rows="4" maxlength="500" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('og_description', $seoMeta?->og_description) }}</textarea>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Meta Keywords</label>
        <input name="meta_keywords" value="{{ old('meta_keywords', $seoMeta?->meta_keywords) }}" maxlength="500" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Canonical URL</label>
            <input type="url" name="canonical_url" value="{{ old('canonical_url', $seoMeta?->canonical_url) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">OG Image</label>
            <input type="file" name="og_image" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
        </div>
    </div>

    @if ($seoMeta?->og_image)
        <div>
            <p class="mb-2 text-sm font-semibold">Current OG Image</p>
            <img src="{{ $seoMeta->ogImageUrl() }}" alt="Current OG image" class="h-32 w-48 rounded-lg object-cover">
        </div>
    @endif

    <div>
        <label class="mb-2 block text-sm font-semibold">Schema JSON-LD</label>
        <textarea name="schema_json_ld" rows="10" class="font-mono w-full rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm focus:border-[#8B5E3C] focus:outline-none">{{ old('schema_json_ld', $seoMeta?->schema_json_ld) }}</textarea>
        <p class="mt-2 text-xs text-[#6F665A]">Paste JSON only, without the script tag.</p>
    </div>

    <div class="flex flex-wrap gap-3">
        <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Save SEO Meta</button>
        <a href="{{ route('admin.seo-meta.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Cancel</a>
    </div>
</div>
