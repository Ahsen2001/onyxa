@extends('layouts.app')

@section('title', 'About Us - ONYXA Private Limited')
@section('meta_description', 'Learn about ONYXA Private Limited, an eco-friendly coconut shell handicraft company creating handmade products for homes, gifts, and sustainable lifestyles.')

@section('content')
    <section class="bg-[#FFF8EC]">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#2E7D32]">About Us</p>
                <h1 class="mt-4 text-4xl font-semibold tracking-tight text-[#2B2B2B] sm:text-5xl">Crafting natural coconut shells into timeless handmade art</h1>
                <p class="mt-6 text-lg leading-8 text-[#5F584F]">
                    ONYXA Private Limited creates eco-friendly coconut shell handicrafts by transforming natural coconut shells into beautiful handmade products for homes, gifts, and sustainable lifestyles.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">Company Introduction</p>
                <h2 class="mt-3 text-3xl font-semibold">{{ page_section('about', 'about_us', 'title', 'A modern craft company rooted in nature') }}</h2>
            </div>
            <p class="text-lg leading-8 text-[#5F584F]">
                {{ page_section('about', 'about_us', 'content', 'We design and produce coconut shell handicrafts that combine natural beauty, careful handwork, and practical use. Our collections are made for customers who value sustainable materials, meaningful gifts, and warm organic design.') }}
            </p>
        </div>
    </section>

    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <article class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm lg:col-span-2">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Our Story</p>
                    <h2 class="mt-3 text-3xl font-semibold">From discarded shell to crafted object</h2>
                    <p class="mt-5 leading-8 text-[#5F584F]">
                        ONYXA was created around a simple idea: natural materials deserve thoughtful design. Coconut shells, often treated as waste, can become elegant bowls, decor, gifts, accessories, and lifestyle products through skilled hands and patient finishing.
                    </p>
                </article>
                <article class="rounded-xl border border-[#E8DCCB] bg-[#2E7D32] p-6 text-white shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#D9A441]">Sustainability</p>
                    <p class="mt-4 text-2xl font-semibold">Every product begins with reuse and ends with lasting purpose.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div class="rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-8">
                <h2 class="text-2xl font-semibold text-[#8B5E3C]">{{ page_section('about', 'vision', 'title', 'Vision') }}</h2>
                <p class="mt-4 leading-8 text-[#5F584F]">
                    {{ page_section('about', 'vision', 'content', 'To become a trusted name in eco-friendly coconut shell handicrafts, known for sustainable design, quality craftsmanship, and products that bring nature into everyday living.') }}
                </p>
            </div>
            <div class="rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-8">
                <h2 class="text-2xl font-semibold text-[#8B5E3C]">{{ page_section('about', 'mission', 'title', 'Mission') }}</h2>
                <p class="mt-4 leading-8 text-[#5F584F]">
                    {{ page_section('about', 'mission', 'content', 'To create beautiful handmade products from coconut shells while supporting responsible material use, preserving craft traditions, and delivering lasting value to customers.') }}
                </p>
            </div>
        </div>
    </section>

    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Core Values</p>
                <h2 class="mt-3 text-3xl font-semibold">The principles behind every piece</h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (['Sustainability', 'Creativity', 'Quality', 'Tradition', 'Innovation', 'Customer satisfaction'] as $value)
                    <div class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                        <div class="mb-4 h-10 w-10 rounded-lg bg-[#D9A441]"></div>
                        <h3 class="text-xl font-semibold">{{ $value }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">Commitment</p>
                <h2 class="mt-3 text-3xl font-semibold">Sustainability is part of the product, not a label after it</h2>
            </div>
            <p class="text-lg leading-8 text-[#5F584F]">
                By reusing coconut shells, ONYXA reduces waste and creates products that celebrate renewable natural resources. Our process favors thoughtful production, durable finishing, and designs that customers can use and appreciate for years.
            </p>
        </div>
    </section>

    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Production Process</p>
                <h2 class="mt-3 text-3xl font-semibold">Handmade from start to finish</h2>
            </div>
            <div class="grid gap-5 md:grid-cols-4">
                @foreach ([['01', 'Select shells'], ['02', 'Clean and cut'], ['03', 'Shape by hand'], ['04', 'Polish and finish']] as [$number, $label])
                    <div class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                        <p class="text-sm font-semibold text-[#D9A441]">{{ $number }}</p>
                        <h3 class="mt-3 text-xl font-semibold">{{ $label }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#2E7D32] py-16 text-white">
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold">Bring sustainable craft into your collection</h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/80">
                Explore ONYXA products or contact us for coconut shell handicrafts, gift collections, and custom product inquiries.
            </p>
            <div class="mt-8 flex justify-center gap-3">
                <a href="{{ route('products.index') }}" class="rounded-lg bg-[#D9A441] px-6 py-3 text-sm font-semibold text-[#2B2B2B]">Explore Products</a>
                <a href="{{ route('contact') }}" class="rounded-lg border border-white/40 px-6 py-3 text-sm font-semibold text-white hover:bg-white hover:text-[#2E7D32]">Contact Us</a>
            </div>
        </div>
    </section>
@endsection
