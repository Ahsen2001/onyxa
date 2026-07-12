@props(['testimonial'])

<article {{ $attributes->merge(['class' => 'flex h-full flex-col rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm']) }}>
    <div class="flex text-[#D9A441]" aria-label="{{ $testimonial->rating }} out of 5 stars">
        @for ($star = 1; $star <= 5; $star++)
            <span class="{{ $star <= $testimonial->rating ? 'text-[#D9A441]' : 'text-[#DCC9AD]' }}">&#9733;</span>
        @endfor
    </div>
    <p class="mt-4 flex-1 leading-8 text-[#5F584F]">"{{ $testimonial->message }}"</p>
    <div class="mt-6 flex items-center gap-3">
        @if ($testimonial->image)
            <img src="{{ asset('storage/'.$testimonial->image) }}" alt="{{ $testimonial->customer_name }}" class="h-14 w-14 rounded-full object-cover">
        @else
            <span class="grid h-14 w-14 place-items-center rounded-full bg-[#2E7D32]/10 text-lg font-bold text-[#2E7D32]">{{ str($testimonial->customer_name)->substr(0, 1)->upper() }}</span>
        @endif
        <div>
            <h3 class="font-semibold">{{ $testimonial->customer_name }}</h3>
            <p class="text-sm text-[#6F665A]">{{ collect([$testimonial->position, $testimonial->company_name])->filter()->join(', ') ?: 'ONYXA customer' }}</p>
        </div>
    </div>
</article>
