@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-title', 'Add Product')

@section('content')
    @if ($categories->isEmpty())
        <div class="mb-5 rounded-lg border border-[#D9A441]/30 bg-[#D9A441]/10 px-4 py-3 text-sm text-[#8B5E3C]">
            Create an active product category before adding products.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @include('admin.products.partials.form', ['product' => null])
    </form>
@endsection
