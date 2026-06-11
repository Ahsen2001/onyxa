@props(['product', 'whatsappNumber' => setting('whatsapp', '')])

<article {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft']) }}>
    <a href="{{ route('products.show', $product) }}" class="block aspect-[4/3] bg-[#EAD7BD]">
        @if ($product->main_image)
            <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
        @endif
    </a>
    <div class="p-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand-green">{{ $product->category?->name }}</p>
        <h3 class="mt-2 text-lg font-semibold text-brand-dark">{{ $product->name }}</h3>
        <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#5F584F]">{{ $product->short_description }}</p>
        <div class="mt-5 flex flex-wrap gap-2">
            <x-ui.button :href="route('products.show', $product)" class="px-4 py-2">View Details</x-ui.button>
            <x-ui.button variant="secondary" href="https://wa.me/{{ preg_replace('/\D+/', '', $whatsappNumber) }}?text={{ urlencode('I am interested in '.$product->name) }}" target="_blank" class="px-4 py-2">WhatsApp</x-ui.button>
        </div>
    </div>
</article>
