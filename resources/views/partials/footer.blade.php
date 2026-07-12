<footer class="bg-[#2B2B2B] text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
        <div>
            <div class="flex items-center gap-3">
                @php($logo = setting('logo'))
                <img src="{{ $logo ? asset('storage/'.$logo) : asset('logo.png') }}" alt="ONYXA logo" class="h-14 w-14 shrink-0 rounded-full bg-white p-1 object-contain ring-2 ring-[#D9A441]">
                <div>
                    <p class="font-semibold">{{ setting('company_name', 'ONYXA Private Limited') }}</p>
                    <p class="text-xs uppercase tracking-[0.18em] text-[#D9A441]">{{ setting('tagline', 'Natural Handicrafts') }}</p>
                </div>
            </div>
            <p class="mt-4 text-sm leading-6 text-white/70">
                {{ page_section('footer', 'description', 'content', setting('footer_text', 'Crafting refined coconut shell handicrafts that celebrate Sri Lankan artistry, natural textures, and sustainable living.')) }}
            </p>
        </div>

        <div>
            <h3 class="font-semibold text-[#D9A441]">Quick Links</h3>
            <div class="mt-4 grid gap-2 text-sm text-white/70">
                <a href="{{ route('about') }}" class="hover:text-white">About Us</a>
                <a href="{{ route('products.index') }}" class="hover:text-white">Products</a>
                <a href="{{ route('news.index') }}" class="hover:text-white">News</a>
                <a href="{{ route('events.index') }}" class="hover:text-white">Events</a>
                <a href="{{ route('gallery.index') }}" class="hover:text-white">Gallery</a>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-[#D9A441]">Contact Info</h3>
            <div class="mt-4 space-y-2 text-sm text-white/70">
                <p>{{ setting('company_name', 'ONYXA Private Limited') }}</p>
                <p>{{ setting('address', 'Sri Lanka') }}</p>
                <p>{{ setting('email', 'info@onyxa.com') }}</p>
                <p>{{ setting('phone', '+94 00 000 0000') }}</p>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-[#D9A441]">Social Media</h3>
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ setting('facebook_url', '#') }}" class="rounded-full border border-white/15 px-3 py-2 text-sm text-white/70 transition hover:border-[#D9A441] hover:text-[#D9A441]">Facebook</a>
                <a href="{{ setting('instagram_url', '#') }}" class="rounded-full border border-white/15 px-3 py-2 text-sm text-white/70 transition hover:border-[#D9A441] hover:text-[#D9A441]">Instagram</a>
                <a href="{{ setting('linkedin_url', '#') }}" class="rounded-full border border-white/15 px-3 py-2 text-sm text-white/70 transition hover:border-[#D9A441] hover:text-[#D9A441]">LinkedIn</a>
                <a href="{{ setting('youtube_url', '#') }}" class="rounded-full border border-white/15 px-3 py-2 text-sm text-white/70 transition hover:border-[#D9A441] hover:text-[#D9A441]">YouTube</a>
            </div>
        </div>
    </div>
    <div class="border-t border-white/10 px-4 py-5 text-center text-sm text-white/60">
        &copy; {{ date('Y') }} ONYXA Private Limited. All rights reserved.
    </div>
</footer>
