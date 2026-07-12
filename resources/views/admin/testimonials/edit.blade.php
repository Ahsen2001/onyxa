@extends('layouts.admin')

@section('title', 'Edit Testimonial')
@section('page-title', 'Edit Testimonial')

@section('content')
    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.testimonials.partials.form')
    </form>
@endsection
