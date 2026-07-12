@extends('layouts.app')

@section('title', 'Testimonials - ONYXA Private Limited')
@section('meta_description', 'Read customer testimonials and feedback about ONYXA coconut shell handicrafts.')

@section('content')
    <section class="bg-[#FFF8EC] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Testimonials</p>
                <h1 class="mt-3 text-4xl font-semibold tracking-tight text-[#2B2B2B] sm:text-5xl">What customers say about ONYXA</h1>
                <p class="mt-5 text-lg leading-8 text-[#5F584F]">Feedback from buyers, partners, and customers who value natural materials, handmade finish, and sustainable craft.</p>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($testimonials as $testimonial)
                    <x-ui.testimonial-card :testimonial="$testimonial" />
                @empty
                    <div class="rounded-xl border border-[#E8DCCB] bg-white p-8 text-center text-[#6F665A] md:col-span-2 lg:col-span-3">
                        Testimonials will appear here soon.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $testimonials->links() }}</div>
        </div>
    </section>
@endsection
