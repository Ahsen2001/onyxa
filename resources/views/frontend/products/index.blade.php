@extends('layouts.app')

@section('title', 'Products - ONYXA Private Limited')
@section('meta_description', 'Browse ONYXA coconut shell handicraft products with category filters, search, and WhatsApp inquiry options.')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Products</p>
            <h1 class="mt-3 text-4xl font-semibold">Coconut shell handicrafts</h1>
            <p class="mt-4 max-w-2xl text-lg leading-8 text-[#5F584F]">Explore handmade coconut shell products for homes, gifts, and sustainable lifestyles.</p>
        </div>
    </section>

    <section class="bg-white py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('products.index') }}" class="grid gap-3 rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-4 md:grid-cols-[1fr_220px_auto]">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search product name" class="rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                <select name="category" class="rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg bg-[#8B5E3C] px-6 py-3 text-sm font-semibold text-white hover:bg-[#724A2E]">Filter</button>
            </form>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($products as $product)
                    <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] shadow-sm">
                        <div class="aspect-[4/3] bg-[#EAD7BD]">
                            @if ($product->main_image)
                                <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#2E7D32]">{{ $product->category?->name }}</p>
                            <h2 class="mt-2 text-xl font-semibold">{{ $product->name }}</h2>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-[#5F584F]">{{ $product->short_description }}</p>
                            <div class="mt-5 flex flex-wrap gap-2">
                                <a href="{{ route('products.show', $product) }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">View Details</a>
                                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('I am interested in '.$product->name) }}" target="_blank" class="rounded-lg border border-[#2E7D32] px-4 py-2 text-sm font-semibold text-[#2E7D32] hover:bg-[#2E7D32] hover:text-white">WhatsApp Inquiry</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-8 text-center text-[#6F665A] sm:col-span-2 lg:col-span-3">
                        No active products found.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $products->links() }}</div>
        </div>
    </section>
@endsection
