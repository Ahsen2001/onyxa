@props(['type' => 'success'])

@php
    $classes = $type === 'error'
        ? 'border-red-200 bg-red-50 text-red-700'
        : 'border-brand-green/20 bg-brand-green/10 text-brand-green';
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg border px-4 py-3 text-sm font-medium '.$classes]) }}>
    {{ $slot }}
</div>
