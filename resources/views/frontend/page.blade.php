@extends('layouts.app')

@section('title', $title.' - ONYXA Private Limited')

@section('content')
    <section class="bg-[#FFF8EC] py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">ONYXA Private Limited</p>
            <h1 class="mt-4 text-4xl font-semibold">{{ $title }}</h1>
            <p class="mt-5 text-lg leading-8 text-[#6F665A]">
                This public page is connected to the ONYXA layout and ready for content.
            </p>
        </div>
    </section>
@endsection
