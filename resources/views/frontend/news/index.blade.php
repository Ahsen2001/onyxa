@extends('layouts.app')

@section('title', 'News - ONYXA Private Limited')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">News</p>
            <h1 class="mt-3 text-4xl font-semibold">Latest company news</h1>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($news as $post)
                    <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
                        <div class="aspect-[4/3] bg-[#EAD7BD]">
                            @if ($post->featured_image)
                                <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-sm text-[#6F665A]">{{ $post->published_at?->format('M d, Y') }}</p>
                            <h2 class="mt-2 text-xl font-semibold">{{ $post->title }}</h2>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-[#5F584F]">{{ $post->short_description }}</p>
                            <a href="{{ route('news.show', $post) }}" class="mt-5 inline-flex rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white">Read More</a>
                        </div>
                    </article>
                @empty
                    <p class="text-[#6F665A]">No published news yet.</p>
                @endforelse
            </div>
            <div class="mt-8">{{ $news->links() }}</div>
        </div>
    </section>
@endsection
