@props(['post'])

<article {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft']) }}>
    <a href="{{ route('news.show', $post) }}" class="block aspect-[16/10] bg-[#EAD7BD]">
        @if ($post->featured_image)
            <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover">
        @endif
    </a>
    <div class="p-5">
        <p class="text-sm font-semibold text-brand-brown">{{ $post->published_at?->format('M d, Y') }}</p>
        <h3 class="mt-2 text-lg font-semibold text-brand-dark">{{ $post->title }}</h3>
        <p class="mt-2 line-clamp-3 text-sm leading-6 text-[#5F584F]">{{ $post->short_description }}</p>
        <a href="{{ route('news.show', $post) }}" class="mt-4 inline-flex text-sm font-semibold text-brand-brown">Read More</a>
    </div>
</article>
