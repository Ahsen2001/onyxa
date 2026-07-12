@extends('layouts.app')

@section('title', 'Search Results - ' . setting('company_name', 'ONYXA Private Limited'))
@section('meta_description', 'Search products, news, and events on ONYXA Private Limited.')

@section('content')
    <section class="bg-[#FFF8EC] py-12 md:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Global Search</p>
            <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl text-[#2B2B2B]">
                @if($query !== '')
                    Search results for &ldquo;{{ $query }}&rdquo;
                @else
                    Search ONYXA
                @endif
            </h1>
            <p class="mt-2 text-sm text-[#6F665A]">
                @if($query !== '')
                    Found {{ $totalCount }} matching item{{ $totalCount !== 1 ? 's' : '' }} across the website.
                @else
                    Enter search keywords to find products, news, or events.
                @endif
            </p>

            <form method="GET" action="{{ route('search') }}" class="mt-8 max-w-2xl">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="search" name="q" value="{{ $query }}" placeholder="Search products, news, events..." 
                               class="w-full rounded-xl border border-[#DCC9AD] bg-white px-4 py-3.5 pr-10 text-base outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15 transition">
                        @if($query !== '')
                            <button type="button" onclick="window.location.href='{{ route('search', ['type' => $type]) }}'" 
                                    class="absolute inset-y-0 right-10 flex items-center px-2 text-[#8B5E3C] hover:text-[#724A2E]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#8B5E3C]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                    </div>
                    <button type="submit" class="rounded-xl bg-[#8B5E3C] px-6 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-[#724A2E] focus:outline-none focus:ring-2 focus:ring-[#8B5E3C]/50 transition shrink-0">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="bg-white py-8 md:py-12 min-h-[400px]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Tabs Filter -->
            <div class="flex flex-wrap gap-2 border-b border-[#E8DCCB] pb-4">
                <a href="{{ route('search', ['q' => $query, 'type' => 'all']) }}" 
                   class="rounded-lg px-4 py-2.5 text-sm font-semibold transition {{ $type === 'all' ? 'bg-[#8B5E3C] text-white shadow-sm' : 'text-[#8B5E3C] hover:bg-[#FFF8EC]' }}">
                    All Results ({{ $totalCount }})
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'products']) }}" 
                   class="rounded-lg px-4 py-2.5 text-sm font-semibold transition {{ $type === 'products' ? 'bg-[#8B5E3C] text-white shadow-sm' : 'text-[#8B5E3C] hover:bg-[#FFF8EC]' }}">
                    Products ({{ $productsCount }})
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'news']) }}" 
                   class="rounded-lg px-4 py-2.5 text-sm font-semibold transition {{ $type === 'news' ? 'bg-[#8B5E3C] text-white shadow-sm' : 'text-[#8B5E3C] hover:bg-[#FFF8EC]' }}">
                    News ({{ $newsCount }})
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'events']) }}" 
                   class="rounded-lg px-4 py-2.5 text-sm font-semibold transition {{ $type === 'events' ? 'bg-[#8B5E3C] text-white shadow-sm' : 'text-[#8B5E3C] hover:bg-[#FFF8EC]' }}">
                    Events ({{ $eventsCount }})
                </a>
            </div>

            @if($query === '')
                <div class="mt-12 flex flex-col items-center text-center">
                    <div class="rounded-full bg-[#FFF8EC] p-4 text-[#8B5E3C]">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-[#2B2B2B]">Ready to search</h3>
                    <p class="mt-2 text-sm text-[#6F665A] max-w-sm">Enter keywords above to find products, latest company news, and upcoming/completed events.</p>
                </div>
            @elseif($results->isEmpty())
                <div class="mt-12 flex flex-col items-center text-center">
                    <div class="rounded-full bg-[#FFF8EC] p-4 text-[#8B5E3C]">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-[#2B2B2B]">No results found</h3>
                    <p class="mt-2 text-sm text-[#6F665A] max-w-sm">We couldn't find anything matching &ldquo;{{ $query }}&rdquo; in the {{ $type === 'all' ? 'website' : $type }} section. Try checking your spelling or using more general terms.</p>
                </div>
            @else
                <!-- Results Grid -->
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($results as $item)
                        @php
                            $showRoute = match($item->type) {
                                'product' => route('products.show', $item->slug),
                                'news' => route('news.show', $item->slug),
                                'event' => route('events.show', $item->slug),
                                default => '#',
                            };

                            $typeBadgeClass = match($item->type) {
                                'product' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                'news' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                'event' => 'bg-purple-50 text-purple-700 border-purple-200/60',
                                default => 'bg-gray-50 text-gray-700 border-gray-200/60',
                            };

                            $formattedDate = null;
                            if ($item->date) {
                                try {
                                    $formattedDate = \Carbon\Carbon::parse($item->date)->format('M d, Y');
                                } catch (\Exception $e) {
                                    $formattedDate = null;
                                }
                            }
                        @endphp

                        <article class="flex flex-col overflow-hidden rounded-xl border border-[#E8DCCB] bg-[#FFF8EC]/40 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md hover:bg-[#FFF8EC]/60">
                            <!-- Image container -->
                            <div class="aspect-[16/10] bg-[#EAD7BD] relative overflow-hidden shrink-0">
                                @if ($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-[#8B5E3C]/40">
                                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 rounded-full border px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider shadow-sm {{ $typeBadgeClass }}">
                                    {{ $item->type }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="flex flex-col flex-1 p-5">
                                @if($formattedDate)
                                    <p class="text-xs font-medium text-[#8B5E3C]">{{ $formattedDate }}</p>
                                @endif
                                
                                <h3 class="mt-2 text-lg font-bold text-[#2B2B2B] line-clamp-1 hover:text-[#8B5E3C] transition">
                                    <a href="{{ $showRoute }}">{{ $item->title }}</a>
                                </h3>
                                
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-[#5F584F] flex-1">
                                    {{ strip_tags($item->description) }}
                                </p>
                                
                                <div class="mt-5 pt-4 border-t border-[#E8DCCB]/60 flex items-center justify-between">
                                    <a href="{{ $showRoute }}" class="inline-flex items-center text-sm font-bold text-[#8B5E3C] hover:text-[#724A2E] transition">
                                        View Details
                                        <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $results->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
