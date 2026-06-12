@extends('layouts.app')

@section('title', 'Events - ONYXA Private Limited')
@section('meta_description', 'Explore upcoming and completed ONYXA coconut shell handicraft events.')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Events</p>
            <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">Upcoming and completed events</h1>

            <div class="mt-8 flex flex-wrap gap-2 rounded-xl border border-[#E8DCCB] bg-white p-3">
                <a href="{{ route('events.index') }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request('status') ? 'text-[#8B5E3C] hover:bg-[#FFF8EC]' : 'bg-[#8B5E3C] text-white' }}">All</a>
                <a href="{{ route('events.index', ['status' => 'upcoming']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request('status') === 'upcoming' ? 'bg-[#8B5E3C] text-white' : 'text-[#8B5E3C] hover:bg-[#FFF8EC]' }}">Upcoming</a>
                <a href="{{ route('events.index', ['status' => 'completed']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request('status') === 'completed' ? 'bg-[#8B5E3C] text-white' : 'text-[#8B5E3C] hover:bg-[#FFF8EC]' }}">Completed</a>
            </div>

            @if (isset($events))
                <h2 class="mt-10 text-2xl font-semibold">{{ ucfirst($status) }} Events</h2>
                <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($events as $event)
                        @include('frontend.events.partials.card', ['event' => $event])
                    @empty
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-8 text-center text-[#6F665A] sm:col-span-2 lg:col-span-3">No {{ $status }} events found.</div>
                    @endforelse
                </div>
                <div class="mt-6">{{ $events->links() }}</div>
            @else
                <h2 class="mt-10 text-2xl font-semibold">Upcoming Events</h2>
                <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($upcomingEvents as $event)
                        @include('frontend.events.partials.card', ['event' => $event])
                    @empty
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-8 text-center text-[#6F665A] sm:col-span-2 lg:col-span-3">No upcoming events yet.</div>
                    @endforelse
                </div>
                <div class="mt-6">{{ $upcomingEvents->links() }}</div>

                <h2 class="mt-14 text-2xl font-semibold">Completed Events</h2>
                <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($completedEvents as $event)
                        @include('frontend.events.partials.card', ['event' => $event])
                    @empty
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-8 text-center text-[#6F665A] sm:col-span-2 lg:col-span-3">No completed events yet.</div>
                    @endforelse
                </div>
                <div class="mt-6">{{ $completedEvents->links() }}</div>
            @endif
        </div>
    </section>
@endsection
