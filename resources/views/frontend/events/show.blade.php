@extends('layouts.app')

@section('title', $event->meta_title ?: $event->title.' - ONYXA Private Limited')
@section('meta_description', $event->meta_description ?: (string) str($event->description)->stripTags()->limit(155))
@section('canonical', route('events.show', $event))
@section('og_type', 'article')
@if ($event->featured_image)
    @section('og_image', asset('storage/'.$event->featured_image))
@endif

@section('content')
    <section class="bg-[#FFF8EC] py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
                @if ($event->featured_image)
                    <img src="{{ asset('storage/'.$event->featured_image) }}" alt="{{ $event->title }}" class="aspect-[16/7] w-full object-cover">
                @endif
                <div class="p-6 lg:p-8">
                    <span class="rounded-full bg-[#2E7D32]/10 px-3 py-1 text-xs font-semibold text-[#2E7D32]">{{ ucfirst($event->status) }}</span>
                    <h1 class="mt-4 text-4xl font-semibold">{{ $event->title }}</h1>
                    <div class="mt-5 grid gap-4 text-sm text-[#5F584F] sm:grid-cols-3">
                        <p><strong>Date:</strong> {{ $event->event_date?->format('M d, Y') }}</p>
                        <p><strong>Time:</strong> {{ $event->event_time ? substr($event->event_time, 0, 5) : '-' }}</p>
                        <p><strong>Location:</strong> {{ $event->location ?? '-' }}</p>
                    </div>
                    <p class="mt-8 whitespace-pre-line leading-8 text-[#2B2B2B]">{{ $event->description }}</p>
                </div>
            </article>

            <section class="mt-10">
                <h2 class="text-3xl font-semibold">Related events</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($relatedEvents as $related)
                        @include('frontend.events.partials.card', ['event' => $related])
                    @empty
                        <p class="text-[#6F665A]">No related events yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </section>
@endsection
