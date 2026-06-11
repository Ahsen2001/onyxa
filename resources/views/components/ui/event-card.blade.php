@props(['event'])

<article {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft']) }}>
    <a href="{{ route('events.show', $event) }}" class="block aspect-[16/10] bg-[#EAD7BD]">
        @if ($event->featured_image)
            <img src="{{ asset('storage/'.$event->featured_image) }}" alt="{{ $event->title }}" class="h-full w-full object-cover">
        @endif
    </a>
    <div class="p-5">
        <x-ui.status-badge :status="$event->status" />
        <h3 class="mt-3 text-lg font-semibold text-brand-dark">{{ $event->title }}</h3>
        <p class="mt-2 text-sm text-[#5F584F]">{{ $event->event_date?->format('M d, Y') }}{{ $event->location ? ' • '.$event->location : '' }}</p>
        <a href="{{ route('events.show', $event) }}" class="mt-4 inline-flex text-sm font-semibold text-brand-brown">View Event</a>
    </div>
</article>
