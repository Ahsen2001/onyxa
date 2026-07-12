@extends('layouts.admin')

@section('title', $news->title)
@section('page-title', $news->title)

@section('content')
    <article class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-wrap gap-3">
            <a href="{{ route('admin.news.edit', $news) }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white">Edit News</a>
            <a href="{{ route('admin.news.index') }}" class="rounded-lg border border-[#DCC9AD] px-4 py-2 text-sm font-semibold text-[#8B5E3C]">Back</a>
        </div>
        @if ($news->featured_image)
            <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title }}" class="mb-6 aspect-[16/7] w-full rounded-xl object-cover">
        @endif
        <p class="text-sm text-[#6F665A]">{{ $news->published_at?->format('M d, Y') }} by {{ $news->user?->name ?? 'Admin' }}</p>
        <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $news->status === 'published' ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($news->status) }}</span>
        <p class="mt-5 text-lg leading-8 text-[#5F584F]">{{ $news->short_description }}</p>
        <div class="mt-8 leading-8">{!! rich_text($news->content) !!}</div>
    </article>
@endsection
