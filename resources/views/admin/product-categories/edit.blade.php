@extends('layouts.admin')

@section('title', 'Edit Product Category')
@section('page-title', 'Edit Product Category')

@section('content')
    <form method="POST" action="{{ route('admin.product-categories.update', $productCategory) }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.product-categories.partials.form', ['category' => $productCategory])
    </form>
@endsection
