<article class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
    <div class="aspect-[4/3] bg-[#EAD7BD]">
        @if ($event->featured_image)
            <img src="{{ asset('storage/'.$event->featured_image) }}" alt="{{ $event->title }}" class="h-full w-full object-cover">
        @endif
    </div>
    <div class="p-5">
        <x-ui.status-badge :status="$event->status" />
        <h3 class="mt-3 text-xl font-semibold">{{ $event->title }}</h3>
        <p class="mt-2 text-sm text-[#6F665A]">{{ $event->event_date?->format('M d, Y') }} @if($event->event_time) at {{ substr($event->event_time, 0, 5) }} @endif</p>
        <p class="mt-1 text-sm text-[#6F665A]">{{ $event->location }}</p>
        <a href="{{ route('events.show', $event) }}" class="mt-5 inline-flex rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white">View Details</a>
    </div>
</article>
