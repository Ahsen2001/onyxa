@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.products.partials.form', ['product' => $product])
    </form>

    <section class="mt-6 rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Additional Images</h2>
        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($product->images as $image)
                <div class="rounded-lg border border-[#E8DCCB] p-3">
                    <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->alt_text ?? $product->name }}" class="aspect-square w-full rounded-lg object-cover">
                    <form method="POST" action="{{ route('admin.product-images.destroy', $image) }}" class="mt-3" onsubmit="return confirm('Delete this image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Delete Image</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-[#6F665A]">No additional images uploaded.</p>
            @endforelse
        </div>
    </section>
@endsection
