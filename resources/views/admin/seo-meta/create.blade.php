@extends('layouts.admin')

@section('title', 'Add SEO Meta')
@section('page-title', 'Add SEO Meta')

@section('content')
    <form method="POST" action="{{ route('admin.seo-meta.store') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @include('admin.seo-meta.partials.form')
    </form>
@endsection
