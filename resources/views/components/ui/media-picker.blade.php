@props([
    'name',
    'label' => 'Media Library Image',
    'currentPath' => null,
    'mediaItems' => collect(),
])

@php($pickerId = 'media-picker-'.str($name)->slug().'-'.uniqid())

<div class="rounded-lg border border-[#DCC9AD] p-4" data-media-picker="{{ $pickerId }}">
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <label class="block text-sm font-semibold">{{ $label }}</label>
            <p class="mt-1 text-xs text-[#6F665A]">Select an existing image, or upload a new file below.</p>
        </div>
        <button type="button" class="rounded-lg border border-[#8B5E3C] px-3 py-2 text-sm font-semibold text-[#8B5E3C]" data-media-open="{{ $pickerId }}">Select Image</button>
    </div>

    <input type="hidden" name="{{ $name }}" value="{{ old($name) }}" data-media-input="{{ $pickerId }}">

    <div class="mt-3 flex items-center gap-3">
        <img src="{{ $currentPath ? asset('storage/'.$currentPath) : '' }}" alt="" class="{{ $currentPath ? '' : 'hidden' }} h-24 w-24 rounded-lg object-cover" data-media-preview="{{ $pickerId }}">
        <button type="button" class="rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm text-[#6F665A]" data-media-clear="{{ $pickerId }}">Clear selection</button>
    </div>

    <div class="fixed inset-0 z-50 hidden bg-black/50 p-4" data-media-modal="{{ $pickerId }}">
        <div class="mx-auto flex max-h-[90vh] max-w-5xl flex-col overflow-hidden rounded-xl bg-white shadow-2xl">
            <div class="flex items-center justify-between gap-3 border-b border-[#E8DCCB] p-4">
                <h2 class="text-lg font-semibold">Select Image</h2>
                <button type="button" class="rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm font-semibold text-[#8B5E3C]" data-media-close="{{ $pickerId }}">Close</button>
            </div>
            <div class="border-b border-[#E8DCCB] p-4">
                <input type="search" placeholder="Search images" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3" data-media-search="{{ $pickerId }}">
            </div>
            <div class="grid gap-3 overflow-y-auto p-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($mediaItems as $media)
                    <button type="button"
                            class="group overflow-hidden rounded-lg border border-[#E8DCCB] bg-white text-left hover:border-[#8B5E3C]"
                            data-media-option="{{ $pickerId }}"
                            data-media-id="{{ $media->id }}"
                            data-media-url="{{ $media->url() }}"
                            data-media-keywords="{{ str($media->file_name.' '.$media->alt_text.' '.$media->file_type)->lower() }}">
                        <img src="{{ $media->url() }}" alt="{{ $media->alt_text ?: $media->file_name }}" class="aspect-square w-full object-cover">
                        <span class="block truncate p-2 text-xs font-semibold group-hover:text-[#8B5E3C]">{{ $media->file_name }}</span>
                    </button>
                @empty
                    <p class="text-[#6F665A] lg:col-span-4">No media images uploaded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
