@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name.' - ONYXA Private Limited')
@section('meta_description', $product->meta_description ?: ($product->short_description ?? 'View ONYXA coconut shell handicraft product details.'))
@section('meta_keywords', $product->meta_keywords ?: $product->tags->pluck('name')->join(', '))
@section('og_title', $product->og_title ?: ($product->meta_title ?: $product->name))
@section('og_description', $product->og_description ?: ($product->meta_description ?: $product->short_description))
@section('canonical', $product->canonical_url ?: route('products.show', $product))
@section('robots', $product->robots ?: 'index, follow')
@section('og_type', 'product')
@if ($product->og_image || $product->main_image)
    @section('og_image', asset('storage/'.($product->og_image ?: $product->main_image)))
@endif

@section('content')
    @php
        $galleryImages = collect();

        if ($product->main_image) {
            $galleryImages->push([
                'url' => asset('storage/'.$product->main_image),
                'alt' => $product->name,
            ]);
        }

        foreach ($product->images as $image) {
            $galleryImages->push([
                'url' => asset('storage/'.$image->image),
                'alt' => $image->alt_text ?: $product->name.' detail image',
            ]);
        }

        $primaryImage = $galleryImages->first();
    @endphp

    <section class="bg-[#FFF8EC] py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#8B5E3C]">Back to products</a>

            <div class="mt-6 grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:gap-10">
                <div data-product-gallery>
                    <div class="group aspect-square overflow-hidden rounded-2xl border border-[#E8DCCB] bg-[#EAD7BD]">
                        @if ($primaryImage)
                            <img src="{{ $primaryImage['url'] }}" alt="{{ $primaryImage['alt'] }}" data-product-main-image class="h-full w-full object-cover transition duration-500 group-hover:scale-125">
                        @else
                            <div class="grid h-full place-items-center text-sm font-semibold text-[#8B5E3C]">No product image</div>
                        @endif
                    </div>

                    @if ($galleryImages->count() > 1)
                        <div class="mt-4 grid grid-cols-4 gap-2 sm:gap-3">
                            @foreach ($galleryImages as $galleryImage)
                                <button type="button" data-product-thumb data-full="{{ $galleryImage['url'] }}" data-alt="{{ $galleryImage['alt'] }}" class="aspect-square overflow-hidden rounded-lg border border-[#E8DCCB] bg-white p-1 transition hover:border-[#8B5E3C]">
                                    <img src="{{ $galleryImage['url'] }}" alt="{{ $galleryImage['alt'] }}" class="h-full w-full rounded-md object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">{{ $product->category?->name }}</p>
                    <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">{{ $product->name }}</h1>
                    <p class="mt-4 text-base leading-7 text-[#5F584F] sm:text-lg sm:leading-8">{{ $product->short_description }}</p>

                    @if ($product->tags->isNotEmpty())
                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($product->tags as $tag)
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-[#2E7D32] ring-1 ring-[#2E7D32]/15">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <dl class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Material</dt><dd class="mt-1 font-semibold">{{ $product->material ?? '-' }}</dd></div>
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Size</dt><dd class="mt-1 font-semibold">{{ $product->size ?? '-' }}</dd></div>
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Availability</dt><dd class="mt-1 font-semibold">{{ ucwords(str_replace('_', ' ', $product->availability)) }}</dd></div>
                        <div class="rounded-xl border border-[#E8DCCB] bg-white p-4"><dt class="text-sm text-[#6F665A]">Price</dt><dd class="mt-1 font-semibold">{{ $product->price ? 'Rs. '.number_format((float) $product->price, 2) : 'Contact for pricing' }}</dd></div>
                    </dl>

                    <div class="mt-8 grid gap-3 sm:flex sm:flex-wrap">
                        <a href="{{ whatsapp_url('Hello ONYXA Private Limited, I am interested in '.$product->name.'. Please send me more details. Product link: '.route('products.show', $product)) }}" target="_blank" rel="noopener" class="rounded-lg bg-[#2E7D32] px-5 py-3 text-center text-sm font-semibold text-white hover:bg-[#256528]">WhatsApp Inquiry</a>
                        <a href="{{ route('contact') }}" class="rounded-lg border border-[#8B5E3C] px-5 py-3 text-center text-sm font-semibold text-[#8B5E3C] hover:bg-[#8B5E3C] hover:text-white">Contact Inquiry</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-14">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_0.8fr] lg:px-8">
            <div>
                <h2 class="text-3xl font-semibold">Product details</h2>
                <div class="mt-4 leading-8 text-[#5F584F]">{!! rich_text($product->description) ?: '<p>Detailed product information will be added soon.</p>' !!}</div>
            </div>

            <div class="rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-5">
                <h2 class="text-2xl font-semibold">Specifications</h2>
                <dl class="mt-5 divide-y divide-[#E8DCCB]">
                    @forelse ($product->specifications as $specification)
                        <div class="grid gap-1 py-3 sm:grid-cols-[150px_1fr]">
                            <dt class="font-semibold text-[#6F665A]">{{ $specification->spec_key }}</dt>
                            <dd>{{ $specification->spec_value }}</dd>
                        </div>
                    @empty
                        <p class="text-[#6F665A]">Specifications will be added soon.</p>
                    @endforelse
                </dl>
            </div>
        </div>
    </section>

    <section class="bg-[#FFF8EC] py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold">Related products</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($relatedProducts as $related)
                    <article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <a href="{{ route('products.show', $related) }}" class="block aspect-[4/3] bg-[#EAD7BD]">
                            @if ($related->main_image)
                                <img src="{{ asset('storage/'.$related->main_image) }}" alt="{{ $related->name }}" class="h-full w-full object-cover">
                            @endif
                        </a>
                        <div class="p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#2E7D32]">{{ $related->category?->name }}</p>
                            <h3 class="mt-2 text-lg font-semibold">{{ $related->name }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#5F584F]">{{ $related->short_description }}</p>
                            <a href="{{ route('products.show', $related) }}" class="mt-4 inline-flex text-sm font-semibold text-[#8B5E3C]">View Details</a>
                        </div>
                    </article>
                @empty
                    <p class="text-[#6F665A]">No related products yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
