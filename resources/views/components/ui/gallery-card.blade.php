@props(['gallery'])

<article {{ $attributes->merge(['class' => 'group overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm']) }}>
    <div class="aspect-square overflow-hidden bg-[#EAD7BD]">
        <img src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->alt_text ?: $gallery->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
    </div>
    <div class="p-4">
        <h3 class="font-semibold text-brand-dark">{{ $gallery->title }}</h3>
        <p class="mt-1 text-sm text-brand-green">{{ $gallery->category?->name }}</p>
    </div>
</article>
