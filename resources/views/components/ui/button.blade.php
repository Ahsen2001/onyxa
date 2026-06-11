@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $classes = $variant === 'secondary'
        ? 'inline-flex items-center justify-center rounded-lg border border-brand-brown px-5 py-3 text-sm font-semibold text-brand-brown transition hover:bg-brand-brown hover:text-white'
        : 'inline-flex items-center justify-center rounded-lg bg-brand-brown px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#70492F]';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
