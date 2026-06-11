@extends('layouts.app')

@section('title', $news->title.' - ONYXA Private Limited')
@section('meta_description', $news->short_description ?? 'Read ONYXA Private Limited company news.')

@section('content')
    <section class="bg-[#FFF8EC] py-12">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_320px] lg:px-8">
            <article class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                @if ($news->featured_image)
                    <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title }}" class="mb-6 aspect-[16/9] w-full rounded-xl object-cover">
                @endif
                <p class="text-sm font-semibold text-[#8B5E3C]">{{ $news->published_at?->format('M d, Y') }}</p>
                <h1 class="mt-3 text-4xl font-semibold">{{ $news->title }}</h1>
                <p class="mt-4 text-lg leading-8 text-[#5F584F]">{{ $news->short_description }}</p>
                <div class="mt-8 whitespace-pre-line leading-8 text-[#2B2B2B]">{{ $news->content }}</div>
            </article>

            <aside class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
                <h2 class="text-xl font-semibold">Latest news</h2>
                <div class="mt-5 space-y-4">
                    @foreach ($relatedNews as $post)
                        <a href="{{ route('news.show', $post) }}" class="block border-b border-[#F0E6D8] pb-4 last:border-0">
                            <p class="font-semibold">{{ $post->title }}</p>
                            <p class="mt-1 text-sm text-[#6F665A]">{{ $post->published_at?->format('M d, Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>
@endsection
