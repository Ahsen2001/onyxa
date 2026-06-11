@props(['title' => null, 'value' => null])

<section {{ $attributes->merge(['class' => 'rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm']) }}>
    @if ($title || $value)
        <p class="text-sm font-medium text-[#6F665A]">{{ $title }}</p>
        <p class="mt-2 text-3xl font-semibold text-brand-dark">{{ $value }}</p>
    @endif
    {{ $slot }}
</section>
