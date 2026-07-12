@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name.' - ONYXA Private Limited')
@section('meta_description', $product->meta_description ?: ($product->short_description ?? 'View ONYXA coconut shell handicraft product details.'))
@section('canonical', route('products.show', $product))
@section('og_type', 'product')
@if ($product->main_image)
    @section('og_image', asset('storage/'.$product->main_image))
@endif

@section('content')
    <section class="bg-[#FFF8EC] py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#8B5E3C]">Back to products</a>

            <div class="mt-6 grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:gap-10">
                <div>
                    <div class="aspect-square overflow-hidden rounded-2xl border border-[#E8DCCB] bg-[#EAD7BD]">
                        @if ($product->main_image)
                            <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <div class="mt-4 grid grid-cols-4 gap-2 sm:gap-3">
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->alt_text ?: $product->name.' detail image' }}" class="aspect-square rounded-lg object-cover">
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">{{ $product->category?->name }}</p>
                    <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">{{ $product->name }}</h1>
                    <p class="mt-4 text-base leading-7 text-[#5F584F] sm:text-lg sm:leading-8">{{ $product->short_description }}</p>

                    <dl class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Material</dt><dd class="mt-1 font-semibold">{{ $product->material ?? '-' }}</dd></div>
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Size</dt><dd class="mt-1 font-semibold">{{ $product->size ?? '-' }}</dd></div>
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Availability</dt><dd class="mt-1 font-semibold">{{ ucwords(str_replace('_', ' ', $product->availability)) }}</dd></div>
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Price</dt><dd class="mt-1 font-semibold">{{ $product->price ? 'Rs. '.number_format((float) $product->price, 2) : 'Contact for pricing' }}</dd></div>
                    </dl>

                    <div class="mt-8">
                        <h2 class="text-xl font-semibold">Description</h2>
                        <div class="mt-3 leading-8 text-[#5F584F]">{!! rich_text($product->description) !!}</div>
                    </div>

                    <div class="mt-8 grid gap-3 sm:flex sm:flex-wrap">
                        <a href="{{ whatsapp_url('Hello ONYXA Private Limited, I am interested in '.$product->name.'. Please send me more details.') }}" target="_blank" rel="noopener" class="rounded-lg bg-[#2E7D32] px-5 py-3 text-center text-sm font-semibold text-white hover:bg-[#256528]">WhatsApp Inquiry</a>
                        <a href="{{ route('contact') }}" class="rounded-lg border border-[#8B5E3C] px-5 py-3 text-center text-sm font-semibold text-[#8B5E3C] hover:bg-[#8B5E3C] hover:text-white">Contact Inquiry</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold">Related products</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($relatedProducts as $related)
                    <article class="rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-5">
                        <h3 class="text-lg font-semibold">{{ $related->name }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm text-[#5F584F]">{{ $related->short_description }}</p>
                        <a href="{{ route('products.show', $related) }}" class="mt-4 inline-flex text-sm font-semibold text-[#8B5E3C]">View Details</a>
                    </article>
                @empty
                    <p class="text-[#6F665A]">No related products yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
