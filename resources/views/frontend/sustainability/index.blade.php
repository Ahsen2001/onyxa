@extends('layouts.app')

@section('title', 'Sustainability - ONYXA Private Limited')

@section('content')
    <section class="bg-[#2E7D32] py-20 text-white">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#D9A441]">Sustainability</p>
            <h1 class="mt-4 text-4xl font-semibold">{{ page_section('sustainability', 'sustainability', 'title', 'Giving coconut shells a second life') }}</h1>
            <p class="mt-6 text-lg leading-8 text-white/80">{{ page_section('sustainability', 'sustainability', 'content', 'ONYXA transforms natural coconut shells into lasting handmade products, reducing waste and celebrating renewable material use.') }}</p>
        </div>
    </section>
@endsection
