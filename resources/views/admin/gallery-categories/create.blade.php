@extends('layouts.admin')
@section('title','Add Gallery Category')
@section('page-title','Add Gallery Category')
@section('content')
    <form method="POST" action="{{ route('admin.gallery-categories.store') }}" class="max-w-2xl rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">@csrf @include('admin.gallery-categories.partials.form',['category'=>null])</form>
@endsection
