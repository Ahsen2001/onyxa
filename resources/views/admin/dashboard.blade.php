@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    @php
        $cards = [
            ['label' => 'Total Products', 'value' => $stats['products'], 'tone' => 'bg-[#8B5E3C]'],
            ['label' => 'News Posts', 'value' => $stats['news'], 'tone' => 'bg-[#2E7D32]'],
            ['label' => 'Events', 'value' => $stats['events'], 'tone' => 'bg-[#D9A441]'],
            ['label' => 'Gallery Images', 'value' => $stats['galleryImages'], 'tone' => 'bg-[#5F6F52]'],
            ['label' => 'Contact Messages', 'value' => $stats['messages'], 'tone' => 'bg-[#6B4F3A]'],
            ['label' => 'Unread Messages', 'value' => $stats['unreadMessages'], 'tone' => 'bg-[#B45309]'],
        ];
    @endphp

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($cards as $card)
            <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-[#6F665A]">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-semibold text-[#2B2B2B]">{{ number_format($card['value']) }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-lg {{ $card['tone'] }}"></div>
                </div>
            </article>
        @endforeach
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-3">
        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Latest News</h2>
                <a href="{{ route('admin.news.index') }}" class="text-sm font-medium text-[#8B5E3C]">View all</a>
            </div>
            <div class="space-y-4">
                @forelse ($latestNews as $post)
                    <div class="border-b border-[#F0E6D8] pb-3 last:border-0 last:pb-0">
                        <p class="font-medium">{{ $post->title }}</p>
                        <p class="mt-1 text-sm text-[#6F665A]">{{ $post->published_at?->format('M d, Y') ?? ucfirst($post->status) }}</p>
                    </div>
                @empty
                    <p class="text-sm text-[#6F665A]">No news posts yet.</p>
                @endforelse
            </div>
        </article>

        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Upcoming Events</h2>
                <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-[#8B5E3C]">View all</a>
            </div>
            <div class="space-y-4">
                @forelse ($upcomingEvents as $event)
                    <div class="border-b border-[#F0E6D8] pb-3 last:border-0 last:pb-0">
                        <p class="font-medium">{{ $event->title }}</p>
                        <p class="mt-1 text-sm text-[#6F665A]">{{ $event->event_date?->format('M d, Y') }} @if($event->location) at {{ $event->location }} @endif</p>
                    </div>
                @empty
                    <p class="text-sm text-[#6F665A]">No upcoming events.</p>
                @endforelse
            </div>
        </article>

        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Recent Messages</h2>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-sm font-medium text-[#8B5E3C]">View all</a>
            </div>
            <div class="space-y-4">
                @forelse ($recentMessages as $message)
                    <div class="border-b border-[#F0E6D8] pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-medium">{{ $message->name }}</p>
                            @unless($message->is_read)
                                <span class="rounded-full bg-[#2E7D32]/10 px-2 py-1 text-xs font-semibold text-[#2E7D32]">New</span>
                            @endunless
                        </div>
                        <p class="mt-1 truncate text-sm text-[#6F665A]">{{ $message->subject ?? $message->message }}</p>
                    </div>
                @empty
                    <p class="text-sm text-[#6F665A]">No contact messages yet.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
