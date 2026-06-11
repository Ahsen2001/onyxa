@extends('layouts.admin')

@section('title', 'Add Product Category')
@section('page-title', 'Add Product Category')

@section('content')
    <form method="POST" action="{{ route('admin.product-categories.store') }}" enctype="multipart/form-data" class="max-w-3xl rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @include('admin.product-categories.partials.form', ['category' => null])
    </form>
@endsection
