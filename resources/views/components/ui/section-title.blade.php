@props([
    'eyebrow' => null,
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'max-w-3xl']) }}>
    @if ($eyebrow)
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-brand-green">{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-brand-dark md:text-4xl">{{ $title }}</h2>
    @if ($description)
        <p class="mt-4 text-base leading-7 text-[#5F584F]">{{ $description }}</p>
    @endif
</div>
