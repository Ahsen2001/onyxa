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

    @php
        $gaSummary = $analytics['summary'];
        $visitorTrend = collect($analytics['visitorTrend']);
        $contactTrend = collect($contactAnalytics['trend']);
        $maxVisitors = max(1, (int) $visitorTrend->max('visitors'));
        $maxContacts = max(1, (int) $contactTrend->max('total'));
        $maxTraffic = max(1, (int) collect($analytics['trafficSources'])->max('sessions'));
        $maxPages = max(1, (int) collect($analytics['popularPages'])->max('views'));
        $maxProducts = max(1, (int) collect($analytics['mostViewedProducts'])->max('views'));
    @endphp

    <section class="mt-6">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">Analytics</p>
                <h2 class="mt-1 text-2xl font-semibold">Website performance</h2>
            </div>
            <p class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#6F665A] ring-1 ring-[#E8DCCB]">Last {{ $analytics['periodDays'] }} days</p>
        </div>

        @unless ($analytics['configured'])
            <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                Google Analytics 4 is not configured yet. Add <code>GA4_PROPERTY_ID</code> and either <code>GA4_CREDENTIALS_PATH</code> or <code>GA4_CLIENT_EMAIL</code>/<code>GA4_PRIVATE_KEY</code> in <code>.env</code>.
            </div>
        @endunless

        @if ($analytics['error'])
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">{{ $analytics['error'] }}</div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Visitors', 'value' => $gaSummary['visitors']],
                ['label' => 'Sessions', 'value' => $gaSummary['sessions']],
                ['label' => 'Page Views', 'value' => $gaSummary['pageViews']],
                ['label' => 'Engagement Rate', 'value' => $gaSummary['engagementRate'].'%'],
            ] as $metric)
                <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-[#6F665A]">{{ $metric['label'] }}</p>
                    <p class="mt-2 text-3xl font-semibold">{{ is_numeric($metric['value']) ? number_format((float) $metric['value']) : $metric['value'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Visitor trend</h2>
            <div class="mt-5 flex h-56 items-end gap-1 border-b border-l border-[#E8DCCB] px-2 pb-2">
                @forelse ($visitorTrend as $point)
                    <div class="group flex min-w-0 flex-1 flex-col items-center justify-end gap-2">
                        <div title="{{ $point['label'] }}: {{ $point['visitors'] }} visitors" class="w-full rounded-t bg-[#2E7D32] transition group-hover:bg-[#8B5E3C]" style="height: {{ max(4, round(($point['visitors'] / $maxVisitors) * 190)) }}px"></div>
                    </div>
                @empty
                    <div class="grid h-full flex-1 place-items-center text-sm text-[#6F665A]">GA4 visitor data will appear here after configuration.</div>
                @endforelse
            </div>
        </article>

        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Contact submissions</h2>
            <div class="mt-4 grid grid-cols-3 gap-3">
                <div class="rounded-lg bg-[#FFF8EC] p-3"><p class="text-xs text-[#6F665A]">30 days</p><p class="text-2xl font-semibold">{{ number_format($contactAnalytics['total']) }}</p></div>
                <div class="rounded-lg bg-[#FFF8EC] p-3"><p class="text-xs text-[#6F665A]">New</p><p class="text-2xl font-semibold">{{ number_format($contactAnalytics['new']) }}</p></div>
                <div class="rounded-lg bg-[#FFF8EC] p-3"><p class="text-xs text-[#6F665A]">Replied</p><p class="text-2xl font-semibold">{{ number_format($contactAnalytics['replied']) }}</p></div>
            </div>
            <div class="mt-5 flex h-32 items-end gap-1 border-b border-l border-[#E8DCCB] px-2 pb-2">
                @foreach ($contactTrend as $point)
                    <div title="{{ $point['label'] }}: {{ $point['total'] }} submissions" class="min-w-0 flex-1 rounded-t bg-[#D9A441]" style="height: {{ max(3, round(($point['total'] / $maxContacts) * 105)) }}px"></div>
                @endforeach
            </div>
        </article>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-3">
        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Popular pages</h2>
            <div class="mt-5 space-y-4">
                @forelse ($analytics['popularPages'] as $page)
                    <div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <div class="min-w-0">
                                <p class="truncate font-semibold">{{ $page['title'] }}</p>
                                <p class="truncate text-xs text-[#6F665A]">{{ $page['path'] }}</p>
                            </div>
                            <span class="font-semibold">{{ number_format($page['views']) }}</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-[#F0E6D8]"><div class="h-2 rounded-full bg-[#8B5E3C]" style="width: {{ round(($page['views'] / $maxPages) * 100) }}%"></div></div>
                    </div>
                @empty
                    <p class="text-sm text-[#6F665A]">No GA4 page data available.</p>
                @endforelse
            </div>
        </article>

        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Most viewed products</h2>
            <div class="mt-5 space-y-4">
                @forelse ($analytics['mostViewedProducts'] as $productPage)
                    <div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <div class="min-w-0">
                                <p class="truncate font-semibold">{{ $productPage['title'] }}</p>
                                <p class="truncate text-xs text-[#6F665A]">{{ $productPage['path'] }}</p>
                            </div>
                            <span class="font-semibold">{{ number_format($productPage['views']) }}</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-[#F0E6D8]"><div class="h-2 rounded-full bg-[#2E7D32]" style="width: {{ round(($productPage['views'] / $maxProducts) * 100) }}%"></div></div>
                    </div>
                @empty
                    <p class="text-sm text-[#6F665A]">Product view data will appear when GA4 tracks product detail URLs.</p>
                @endforelse
            </div>
        </article>

        <article class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Traffic sources</h2>
            <div class="mt-5 space-y-4">
                @forelse ($analytics['trafficSources'] as $source)
                    <div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <p class="truncate font-semibold">{{ $source['source'] }}</p>
                            <span>{{ number_format($source['sessions']) }} sessions</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-[#F0E6D8]"><div class="h-2 rounded-full bg-[#D9A441]" style="width: {{ round(($source['sessions'] / $maxTraffic) * 100) }}%"></div></div>
                    </div>
                @empty
                    <p class="text-sm text-[#6F665A]">No GA4 traffic source data available.</p>
                @endforelse
            </div>
        </article>
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
