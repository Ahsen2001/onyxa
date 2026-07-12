@extends('layouts.admin')

@section('title', $product->name)
@section('page-title', $product->name)

@section('content')
    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Edit Product</a>
        <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-[#DCC9AD] px-4 py-2 text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC]">Back to Products</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <section class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
            <div class="aspect-square overflow-hidden rounded-xl bg-[#EAD7BD]">
                @if ($product->main_image)
                    <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @endif
            </div>
        </section>

        <section class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">{{ $product->category?->name }}</p>
            <h2 class="mt-2 text-3xl font-semibold">{{ $product->name }}</h2>
            <p class="mt-2 text-sm text-[#6F665A]">{{ $product->slug }}</p>

            <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                <div><dt class="text-sm text-[#6F665A]">Price</dt><dd class="font-semibold">{{ $product->price ? 'Rs. '.number_format((float) $product->price, 2) : '-' }}</dd></div>
                <div><dt class="text-sm text-[#6F665A]">Availability</dt><dd class="font-semibold">{{ ucwords(str_replace('_', ' ', $product->availability)) }}</dd></div>
                <div><dt class="text-sm text-[#6F665A]">Material</dt><dd class="font-semibold">{{ $product->material ?? '-' }}</dd></div>
                <div><dt class="text-sm text-[#6F665A]">Size</dt><dd class="font-semibold">{{ $product->size ?? '-' }}</dd></div>
                <div><dt class="text-sm text-[#6F665A]">Status</dt><dd class="font-semibold">{{ ucfirst($product->status) }}</dd></div>
                <div><dt class="text-sm text-[#6F665A]">Featured</dt><dd class="font-semibold">{{ $product->is_featured ? 'Yes' : 'No' }}</dd></div>
            </dl>

            <div class="mt-6">
                <h3 class="font-semibold">Tags</h3>
                <div class="mt-2 flex flex-wrap gap-2">
                    @forelse ($product->tags as $tag)
                        <span class="rounded-full bg-[#2E7D32]/10 px-3 py-1 text-xs font-semibold text-[#2E7D32]">{{ $tag->name }}</span>
                    @empty
                        <span class="text-sm text-[#6F665A]">No tags added.</span>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                <h3 class="font-semibold">Short Description</h3>
                <p class="mt-2 leading-7 text-[#5F584F]">{{ $product->short_description ?? '-' }}</p>
            </div>

            <div class="mt-6">
                <h3 class="font-semibold">Description</h3>
                <div class="mt-2 leading-7 text-[#5F584F]">{!! rich_text($product->description) ?: '-' !!}</div>
            </div>
        </section>
    </div>

    <section class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Specifications</h2>
            <dl class="mt-5 divide-y divide-[#F0E6D8]">
                @forelse ($product->specifications as $specification)
                    <div class="grid gap-2 py-3 sm:grid-cols-[180px_1fr]">
                        <dt class="font-semibold text-[#6F665A]">{{ $specification->spec_key }}</dt>
                        <dd>{{ $specification->spec_value }}</dd>
                    </div>
                @empty
                    <p class="text-sm text-[#6F665A]">No specifications added.</p>
                @endforelse
            </dl>
        </div>

        <div class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Related Products</h2>
            <div class="mt-5 grid gap-3">
                @forelse ($product->relatedProducts as $relatedProduct)
                    <a href="{{ route('admin.products.show', $relatedProduct) }}" class="rounded-lg border border-[#E8DCCB] px-4 py-3 font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC]">{{ $relatedProduct->name }}</a>
                @empty
                    <p class="text-sm text-[#6F665A]">No manual related products selected.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mt-6 rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">SEO</h2>
        <dl class="mt-5 grid gap-4 md:grid-cols-2">
            <div><dt class="text-sm text-[#6F665A]">Meta Title</dt><dd class="font-semibold">{{ $product->meta_title ?: '-' }}</dd></div>
            <div><dt class="text-sm text-[#6F665A]">Meta Keywords</dt><dd class="font-semibold">{{ $product->meta_keywords ?: '-' }}</dd></div>
            <div><dt class="text-sm text-[#6F665A]">OG Title</dt><dd class="font-semibold">{{ $product->og_title ?: '-' }}</dd></div>
            <div><dt class="text-sm text-[#6F665A]">Robots</dt><dd class="font-semibold">{{ $product->robots ?: 'index, follow' }}</dd></div>
            <div class="md:col-span-2"><dt class="text-sm text-[#6F665A]">Meta Description</dt><dd class="font-semibold">{{ $product->meta_description ?: '-' }}</dd></div>
            <div class="md:col-span-2"><dt class="text-sm text-[#6F665A]">OG Description</dt><dd class="font-semibold">{{ $product->og_description ?: '-' }}</dd></div>
            <div class="md:col-span-2"><dt class="text-sm text-[#6F665A]">Canonical URL</dt><dd class="font-semibold">{{ $product->canonical_url ?: '-' }}</dd></div>
        </dl>
    </section>

    <section class="mt-6 rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Additional Images</h2>
        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($product->images as $image)
                <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->alt_text ?? $product->name }}" class="aspect-square rounded-lg object-cover">
            @empty
                <p class="text-sm text-[#6F665A]">No additional images uploaded.</p>
            @endforelse
        </div>
    </section>
@endsection
