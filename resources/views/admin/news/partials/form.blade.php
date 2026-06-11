<div class="grid gap-5">
    <div>
        <label class="mb-2 block text-sm font-semibold">Title</label>
        <input name="title" value="{{ old('title', $post?->title) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        <p class="mt-2 text-xs text-[#6F665A]">Slug is generated automatically from the title.</p>
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold">Short Description</label>
        <textarea name="short_description" rows="3" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('short_description', $post?->short_description) }}</textarea>
    </div>
    <div>
        <label class="mb-2 block text-sm font-semibold">Content</label>
        <textarea name="content" rows="10" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('content', $post?->content) }}</textarea>
    </div>
    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label class="mb-2 block text-sm font-semibold">Featured Image</label>
            <input type="file" name="featured_image" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Status</label>
            <select name="status" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
                @foreach (['draft' => 'Draft', 'published' => 'Published'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $post?->status ?? 'draft') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Published At</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', $post?->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
        </div>
    </div>
    @if ($post?->featured_image)
        <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="h-32 w-48 rounded-lg object-cover">
    @endif
    <div class="flex flex-wrap gap-3">
        <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Save News</button>
        <a href="{{ route('admin.news.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Cancel</a>
    </div>
</div>
