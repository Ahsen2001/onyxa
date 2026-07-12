@extends('layouts.admin')

@section('title', 'Media Library')
@section('page-title', 'Media Library')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            @csrf
            <h2 class="text-xl font-semibold">Upload Images</h2>
            <div class="mt-5 grid gap-4">
                <div>
                    <label class="mb-2 block text-sm font-semibold">Images</label>
                    <input type="file" name="images[]" accept="image/*" multiple required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
                    <p class="mt-2 text-xs text-[#6F665A]">JPG, PNG, or WebP. Max 4 MB each.</p>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold">Alt Text</label>
                    <input name="alt_text" value="{{ old('alt_text') }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
                </div>
                <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Upload</button>
            </div>
        </form>

        <section>
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <form method="GET" action="{{ route('admin.media.index') }}" class="flex min-w-0 flex-1 gap-2">
                    <input name="search" value="{{ $search }}" placeholder="Search by file name, alt text, or type" class="min-w-0 flex-1 rounded-lg border border-[#DCC9AD] px-4 py-3">
                    <button class="rounded-lg border border-[#8B5E3C] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Search</button>
                </form>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($media as $item)
                    <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
                        <img src="{{ $item->url() }}" alt="{{ $item->alt_text ?: $item->file_name }}" class="aspect-[4/3] w-full object-cover">
                        <div class="p-4">
                            <p class="line-clamp-1 font-semibold">{{ $item->file_name }}</p>
                            <p class="mt-1 text-xs text-[#6F665A]">{{ $item->file_type }} / {{ $item->sizeForHumans() }}</p>
                            <p class="mt-1 line-clamp-1 text-xs text-[#6F665A]">{{ $item->alt_text ?: 'No alt text' }}</p>
                            <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="mt-4" onsubmit="return confirm('Delete this image if it is unused?');">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete unused</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-[#E8DCCB] bg-white p-8 text-center text-[#6F665A] sm:col-span-2 xl:col-span-3">
                        No images found.
                    </div>
                @endforelse
            </div>

            <div class="mt-5">{{ $media->links() }}</div>
        </section>
    </div>
@endsection
