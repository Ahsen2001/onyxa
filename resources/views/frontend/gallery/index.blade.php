@extends('layouts.app')

@section('title', 'Gallery - ONYXA Private Limited')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Gallery</p>
            <h1 class="mt-3 text-4xl font-semibold">Our coconut shell craft moments</h1>

            <div class="mt-8 flex flex-wrap gap-2">
                <a href="{{ route('gallery.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ request('category') ? 'bg-white text-[#8B5E3C]' : 'bg-[#8B5E3C] text-white' }}">All</a>
                @foreach ($categories as $category)
                    <a href="{{ route('gallery.index', ['category' => $category->slug]) }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ request('category') === $category->slug ? 'bg-[#8B5E3C] text-white' : 'bg-white text-[#8B5E3C]' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($images as $image)
                    <button type="button" class="group overflow-hidden rounded-xl border border-[#E8DCCB] bg-white text-left shadow-sm" onclick="openLightbox('{{ asset('storage/'.$image->image) }}', '{{ addslashes($image->title ?? 'ONYXA gallery image') }}')">
                        <div class="aspect-[4/3] overflow-hidden bg-[#EAD7BD]">
                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        </div>
                        <div class="p-4">
                            <p class="font-semibold">{{ $image->title ?? 'Gallery Image' }}</p>
                            <p class="mt-1 text-sm text-[#6F665A]">{{ $image->category?->name ?? 'ONYXA' }}</p>
                        </div>
                    </button>
                @empty
                    <p class="text-[#6F665A]">No gallery images yet.</p>
                @endforelse
            </div>

            <div class="mt-8">{{ $images->links() }}</div>
        </div>
    </section>

    <div id="lightbox" class="fixed inset-0 z-50 hidden bg-black/80 p-4" onclick="closeLightbox()">
        <div class="flex min-h-full items-center justify-center">
            <div class="max-w-5xl" onclick="event.stopPropagation()">
                <img id="lightbox-image" src="" alt="" class="max-h-[80vh] rounded-xl object-contain">
                <div class="mt-4 flex items-center justify-between gap-4 text-white">
                    <p id="lightbox-title" class="font-semibold"></p>
                    <button type="button" onclick="closeLightbox()" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-[#2B2B2B]">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openLightbox(src, title) {
            document.getElementById('lightbox-image').src = src;
            document.getElementById('lightbox-title').textContent = title;
            document.getElementById('lightbox').classList.remove('hidden');
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
        }
    </script>
@endsection
