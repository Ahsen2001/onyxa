@extends('layouts.app')

@section('title', 'Products - ONYXA Private Limited')
@section('meta_description', 'Browse ONYXA coconut shell handicraft products with category filters, search, and WhatsApp inquiry options.')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Products</p>
            <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">Coconut shell handicrafts</h1>
            <p class="mt-4 max-w-2xl text-base leading-7 text-[#5F584F] sm:text-lg sm:leading-8">Explore handmade coconut shell products for homes, gifts, and sustainable lifestyles.</p>
        </div>
    </section>

    <section class="bg-white py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('products.index') }}" class="grid gap-3 rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-4 sm:grid-cols-2 lg:grid-cols-[1fr_220px_220px_auto_auto]">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search product name" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15 sm:col-span-2 lg:col-span-1">
                <select name="category" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="availability" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                    <option value="">All availability</option>
                    <option value="available" @selected(request('availability') === 'available')>Available</option>
                    <option value="made_to_order" @selected(request('availability') === 'made_to_order')>Made to order</option>
                    <option value="out_of_stock" @selected(request('availability') === 'out_of_stock')>Out of stock</option>
                </select>
                <button class="rounded-lg bg-[#8B5E3C] px-6 py-3 text-sm font-semibold text-white hover:bg-[#724A2E]">Filter</button>
                <a href="{{ route('products.index') }}" class="rounded-lg border border-[#DCC9AD] px-6 py-3 text-center text-sm font-semibold text-[#8B5E3C] hover:bg-white">Reset</a>
            </form>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($products as $product)
                    <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
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
                                <a href="{{ whatsapp_url('Hello ONYXA Private Limited, I am interested in '.$product->name.'. Please send me more details.') }}" target="_blank" rel="noopener" class="rounded-lg border border-[#2E7D32] px-4 py-2 text-sm font-semibold text-[#2E7D32] hover:bg-[#2E7D32] hover:text-white">WhatsApp Inquiry</a>
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
