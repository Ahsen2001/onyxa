@extends('layouts.app')

@section('title', 'News - ONYXA Private Limited')
@section('meta_description', 'Read ONYXA Private Limited news, announcements, and coconut shell handicraft updates.')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">News</p>
            <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">Latest company news</h1>

            <form method="GET" action="{{ route('news.index') }}" class="mt-8 grid gap-3 rounded-xl border border-[#E8DCCB] bg-white p-4 sm:grid-cols-[1fr_180px_auto_auto]">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search news title" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15 sm:col-span-2 lg:col-span-1">
                <select name="sort" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                    <option value="latest" @selected(request('sort', 'latest') === 'latest')>Latest first</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Oldest first</option>
                </select>
                <button class="rounded-lg bg-[#8B5E3C] px-6 py-3 text-sm font-semibold text-white hover:bg-[#724A2E]">Filter</button>
                <a href="{{ route('news.index') }}" class="rounded-lg border border-[#DCC9AD] px-6 py-3 text-center text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC]">Reset</a>
            </form>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($news as $post)
                    <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
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
                    <div class="rounded-xl border border-[#E8DCCB] bg-white p-8 text-center text-[#6F665A] sm:col-span-2 lg:col-span-3">No published news found.</div>
                @endforelse
            </div>
            <div class="mt-8">{{ $news->links() }}</div>
        </div>
    </section>
@endsection
