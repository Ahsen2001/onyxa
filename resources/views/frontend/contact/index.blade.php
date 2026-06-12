@extends('layouts.app')

@section('title', 'Contact Us - ONYXA Private Limited')

@section('content')
    @php
        $defaultMapEmbed = '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6685.892296011982!2d81.50099093143679!3d7.9442799766397085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slk!4v1781241808012!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="h-72 w-full rounded-lg"></iframe>';
        $mapEmbed = setting('google_map_embed', $defaultMapEmbed) ?: $defaultMapEmbed;
    @endphp

    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Contact</p>
            <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">Talk to ONYXA</h1>
            <div class="mt-10 grid gap-8 lg:grid-cols-[0.85fr_1.15fr]">
                <aside class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                    <div class="grid gap-5 text-[#5F584F]">
                        <p><strong class="text-[#2B2B2B]">Address:</strong><br>{{ setting('address', 'Sri Lanka') }}</p>
                        <p><strong class="text-[#2B2B2B]">Email:</strong><br>{{ setting('email', 'info@onyxa.com') }}</p>
                        <p><strong class="text-[#2B2B2B]">Phone:</strong><br>{{ setting('phone', '+94 00 000 0000') }}</p>
                        <p><strong class="text-[#2B2B2B]">WhatsApp:</strong><br>{{ setting('whatsapp', '+94 00 000 0000') }}</p>
                        <p><strong class="text-[#2B2B2B]">Business Hours:</strong><br>{{ setting('business_hours', 'Monday - Friday, 9.00 AM - 5.00 PM') }}</p>
                    </div>
                    <a href="{{ whatsapp_url('Hello ONYXA Private Limited, I would like to know more about your coconut shell handicrafts.') }}" target="_blank" rel="noopener" class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-[#2E7D32] px-5 py-3 text-sm font-semibold text-white hover:bg-[#256528]">Chat on WhatsApp</a>
                </aside>

                <div class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                    @if (session('success'))
                        <div class="mb-5 rounded-lg bg-[#2E7D32]/10 px-4 py-3 text-sm font-semibold text-[#2E7D32]">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}" class="grid gap-5">
                        @csrf
                        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                        <div class="grid gap-5 md:grid-cols-2">
                            <input name="name" value="{{ old('name') }}" placeholder="Your name" required class="rounded-lg border border-[#DCC9AD] px-4 py-3 outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required class="rounded-lg border border-[#DCC9AD] px-4 py-3 outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                        </div>
                        <div class="grid gap-5 md:grid-cols-2">
                            <input name="phone" value="{{ old('phone') }}" placeholder="Phone" class="rounded-lg border border-[#DCC9AD] px-4 py-3 outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                            <input name="subject" value="{{ old('subject') }}" placeholder="Subject" class="rounded-lg border border-[#DCC9AD] px-4 py-3 outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                        </div>
                        <textarea name="message" rows="6" placeholder="Message" required class="rounded-lg border border-[#DCC9AD] px-4 py-3 outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">{{ old('message') }}</textarea>
                        @error('message')<p class="text-sm text-red-700">{{ $message }}</p>@enderror
                        <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Send Message</button>
                    </form>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-xl border border-[#E8DCCB] bg-white p-4">
                {!! $mapEmbed !!}
            </div>
        </div>
    </section>
@endsection
