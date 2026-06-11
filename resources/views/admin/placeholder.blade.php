@extends('layouts.admin')

@section('title', $title)
@section('page-title', $title)

@section('content')
    <div class="rounded-xl border border-[#E8DCCB] bg-white p-8 shadow-sm">
        <p class="text-sm font-medium uppercase tracking-[0.18em] text-[#8B5E3C]">Admin Module</p>
        <h2 class="mt-2 text-2xl font-semibold">{{ $title }}</h2>
        <p class="mt-3 max-w-2xl text-[#6F665A]">
            This page is protected by the admin middleware and ready for CRUD screens.
        </p>
    </div>
@endsection
