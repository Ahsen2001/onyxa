@extends('layouts.app')

@section('title', 'Events - ONYXA Private Limited')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Events</p>
            <h1 class="mt-3 text-4xl font-semibold">Upcoming and completed events</h1>

            <h2 class="mt-10 text-2xl font-semibold">Upcoming Events</h2>
            <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($upcomingEvents as $event)
                    @include('frontend.events.partials.card', ['event' => $event])
                @empty
                    <p class="text-[#6F665A]">No upcoming events yet.</p>
                @endforelse
            </div>
            <div class="mt-6">{{ $upcomingEvents->links() }}</div>

            <h2 class="mt-14 text-2xl font-semibold">Completed Events</h2>
            <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($completedEvents as $event)
                    @include('frontend.events.partials.card', ['event' => $event])
                @empty
                    <p class="text-[#6F665A]">No completed events yet.</p>
                @endforelse
            </div>
            <div class="mt-6">{{ $completedEvents->links() }}</div>
        </div>
    </section>
@endsection
