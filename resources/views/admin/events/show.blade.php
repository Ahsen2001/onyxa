@extends('layouts.admin')
@section('title', $event->title)
@section('page-title', $event->title)
@section('content')
    <article class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        <div class="mb-6 flex gap-3"><a href="{{ route('admin.events.edit', $event) }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white">Edit Event</a><a href="{{ route('admin.events.index') }}" class="rounded-lg border border-[#DCC9AD] px-4 py-2 text-sm font-semibold text-[#8B5E3C]">Back</a></div>
        @if ($event->featured_image)<img src="{{ asset('storage/'.$event->featured_image) }}" alt="{{ $event->title }}" class="mb-6 aspect-[16/7] w-full rounded-xl object-cover">@endif
        <span class="rounded-full bg-[#2E7D32]/10 px-3 py-1 text-xs font-semibold text-[#2E7D32]">{{ ucfirst($event->status) }}</span>
        <p class="mt-5 text-[#6F665A]">{{ $event->event_date?->format('M d, Y') }} @if($event->event_time) at {{ substr($event->event_time, 0, 5) }} @endif - {{ $event->location }}</p>
        <div class="mt-8 whitespace-pre-line leading-8">{{ $event->description }}</div>
    </article>
@endsection
