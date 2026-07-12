@extends('layouts.admin')

@section('title', 'Pages')
@section('page-title', 'Pages')

@section('content')
    <div class="grid gap-4">
        @foreach ($pages as $page)
            <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8B5E3C]">{{ $page->page_key }} / {{ $page->section_key }}</p>
                        <h2 class="mt-1 text-xl font-semibold">{{ $page->title }}</h2>
                        <p class="mt-2 line-clamp-2 text-sm text-[#6F665A]">{{ str($page->content ? strip_tags($page->content) : 'No custom content yet. Fallback content will display publicly.')->squish() }}</p>
                    </div>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="rounded-lg border border-[#DCC9AD] px-4 py-2 text-sm font-semibold text-[#8B5E3C]">Edit</a>
                </div>
            </article>
        @endforeach
    </div>
@endsection
