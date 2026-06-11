@extends('layouts.admin')

@section('title', 'Add News')
@section('page-title', 'Add News')

@section('content')
    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @include('admin.news.partials.form', ['post' => null])
    </form>
@endsection
