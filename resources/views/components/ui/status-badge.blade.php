@props(['status'])

@php
    $palette = match ($status) {
        'published', 'active', 'available', 'upcoming' => 'bg-brand-green/10 text-brand-green',
        'draft', 'made_to_order' => 'bg-brand-gold/15 text-[#8A641E]',
        'inactive', 'cancelled', 'out_of_stock' => 'bg-red-50 text-red-700',
        'completed', 'read' => 'bg-slate-100 text-slate-700',
        'unread' => 'bg-brand-gold/15 text-[#8A641E]',
        default => 'bg-[#FFF8EC] text-brand-brown',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex rounded-full px-3 py-1 text-xs font-semibold '.$palette]) }}>
    {{ ucwords(str_replace('_', ' ', (string) $status)) }}
</span>
