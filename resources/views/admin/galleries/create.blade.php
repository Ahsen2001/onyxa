@extends('layouts.admin')
@section('title','Upload Gallery Image')
@section('page-title','Upload Gallery Image')
@section('content')
    <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">@csrf @include('admin.galleries.partials.form',['gallery'=>null])</form>
@endsection
