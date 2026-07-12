@extends('layouts.admin')

@section('title', 'Edit SEO Meta')
@section('page-title', 'Edit SEO Meta')

@section('content')
    <form method="POST" action="{{ route('admin.seo-meta.update', $seoMeta) }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.seo-meta.partials.form')
    </form>
@endsection
