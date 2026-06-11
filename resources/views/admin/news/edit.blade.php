@extends('layouts.admin')

@section('title', 'Edit News')
@section('page-title', 'Edit News')

@section('content')
    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.news.partials.form', ['post' => $news])
    </form>
@endsection
