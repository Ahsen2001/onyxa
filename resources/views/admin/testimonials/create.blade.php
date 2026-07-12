@extends('layouts.admin')

@section('title', 'Add Testimonial')
@section('page-title', 'Add Testimonial')

@section('content')
    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @include('admin.testimonials.partials.form')
    </form>
@endsection
