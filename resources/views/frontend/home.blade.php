@extends('layouts.app')

@section('title', 'ONYXA Private Limited - Crafting Nature into Timeless Art')
@section('meta_description', 'Explore coconut shell handicrafts, sustainable artistry, company news, events, and gallery highlights from ONYXA Private Limited.')

@section('content')
    <section class="relative overflow-hidden bg-[#FFF8EC]">
        <div class="absolute inset-x-0 top-0 h-24 bg-[#2E7D32]/10"></div>
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:py-24">
            <div class="relative">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-[#2E7D32]">Coconut Shell Handicrafts</p>
                <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-[#2B2B2B] sm:text-5xl lg:text-6xl">
                    ONYXA Private Limited
                </h1>
                <p class="mt-4 text-2xl font-medium text-[#8B5E3C]">Crafting Nature into Timeless Art</p>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-[#5F584F]">
                    {{ page_section('home', 'introduction', 'content', 'We transform coconut shells into refined handmade pieces that bring natural warmth, practical beauty, and sustainable craftsmanship into modern spaces.') }}
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="rounded-lg bg-[#8B5E3C] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#724A2E]">Explore Products</a>
                    <a href="{{ route('contact') }}" class="rounded-lg border border-[#8B5E3C] px-6 py-3 text-sm font-semibold text-[#8B5E3C] transition hover:bg-[#8B5E3C] hover:text-white">Contact Us</a>
                </div>
            </div>

            <div class="relative">
                <div class="aspect-[4/3] overflow-hidden rounded-2xl border border-[#E8DCCB] bg-[#EAD7BD] shadow-xl">
                    <img src="{{ asset('logo.png') }}" alt="ONYXA coconut shell handicraft brand" class="h-full w-full object-cover">
                </div>
                <div class="absolute -bottom-5 left-6 rounded-xl bg-white px-5 py-4 shadow-lg">
                    <p class="text-sm font-medium text-[#6F665A]">Eco-friendly artistry</p>
                    <p class="text-2xl font-semibold text-[#2E7D32]">Handmade in nature's tone</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">About ONYXA</p>
                <h2 class="mt-3 text-3xl font-semibold">Natural craft with a modern finish</h2>
            </div>
            <p class="text-lg leading-8 text-[#5F584F]">
                ONYXA Private Limited creates coconut shell handicrafts for homes, gifts, decor, and lifestyle collections. Every piece reflects careful material selection, hand finishing, and a commitment to giving natural waste a second life.
            </p>
        </div>
    </section>

    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Featured Products</p>
                    <h2 class="mt-3 text-3xl font-semibold">Coconut shell pieces worth noticing</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#8B5E3C]">View products</a>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($featuredProducts as $product)
                    <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
                        <div class="aspect-[4/3] bg-[#EAD7BD]">
                            @if ($product->main_image)
                                <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#2E7D32]">{{ $product->category?->name ?? 'Handicraft' }}</p>
                            <h3 class="mt-2 text-lg font-semibold">{{ $product->name }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#6F665A]">{{ $product->short_description ?? 'A carefully finished coconut shell handicraft from ONYXA.' }}</p>
                        </div>
                    </article>
                @empty
                    @foreach (['Decor Bowls', 'Natural Jewelry', 'Table Pieces'] as $sample)
                        <article class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                            <div class="mb-5 aspect-[4/3] rounded-lg bg-[#EAD7BD]"></div>
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#2E7D32]">Sample Product</p>
                            <h3 class="mt-2 text-lg font-semibold">{{ $sample }}</h3>
                            <p class="mt-2 text-sm leading-6 text-[#6F665A]">Add featured products in the admin panel to display real items here.</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-5 md:grid-cols-3">
                @foreach ([['Handmade Quality', 'Careful finishing and natural textures in every product.'], ['Sustainable Materials', 'Coconut shells are reused as durable craft material.'], ['Elegant Utility', 'Decorative and functional pieces for modern spaces.']] as [$title, $text])
                    <div class="rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-6">
                        <h3 class="text-xl font-semibold">{{ $title }}</h3>
                        <p class="mt-3 leading-7 text-[#6F665A]">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-semibold">Latest News</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($latestNews as $post)
                        <div class="border-b border-[#F0E6D8] pb-4 last:border-0">
                            <p class="font-semibold">{{ $post->title }}</p>
                            <p class="mt-1 text-sm text-[#6F665A]">{{ $post->published_at?->format('M d, Y') }}</p>
                        </div>
                    @empty
                        <p class="text-[#6F665A]">Latest company news will appear here.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-semibold">Upcoming Events</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($upcomingEvents as $event)
                        <div class="border-b border-[#F0E6D8] pb-4 last:border-0">
                            <p class="font-semibold">{{ $event->title }}</p>
                            <p class="mt-1 text-sm text-[#6F665A]">{{ $event->event_date?->format('M d, Y') }} @if($event->location) - {{ $event->location }} @endif</p>
                        </div>
                    @empty
                        <p class="text-[#6F665A]">Upcoming exhibitions and events will appear here.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">Gallery</p>
                    <h2 class="mt-3 text-3xl font-semibold">A glimpse of our craft</h2>
                </div>
                <a href="{{ route('gallery.index') }}" class="text-sm font-semibold text-[#8B5E3C]">View gallery</a>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($galleryImages as $image)
                    <div class="aspect-[4/3] overflow-hidden rounded-xl bg-[#EAD7BD]">
                        <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->alt_text ?? $image->title ?? 'ONYXA gallery image' }}" class="h-full w-full object-cover">
                    </div>
                @empty
                    @foreach (range(1, 6) as $item)
                        <div class="aspect-[4/3] rounded-xl bg-[#EAD7BD]"></div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-[#2E7D32] py-16 text-white">
        <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#D9A441]">Sustainability</p>
            <div>
                <h2 class="text-3xl font-semibold">Giving coconut shells a beautiful second life</h2>
                <p class="mt-4 text-lg leading-8 text-white/80">
                    Our work supports eco-conscious production by turning natural byproducts into lasting handcrafted objects with purpose, character, and cultural value.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold">Start a conversation with ONYXA</h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-[#6F665A]">
                Interested in coconut shell handicrafts, custom orders, events, or partnerships? Our team is ready to help.
            </p>
            <a href="{{ route('contact') }}" class="mt-8 inline-flex rounded-lg bg-[#8B5E3C] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#724A2E]">Contact Us</a>
        </div>
    </section>
@endsection
