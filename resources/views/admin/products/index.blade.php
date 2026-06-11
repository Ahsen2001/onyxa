@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-[#6F665A]">Manage ONYXA coconut shell handicraft products.</p>
        <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Add Product</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
                <thead class="bg-[#FFF8EC] text-left text-[#6F665A]">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Product</th>
                        <th class="px-5 py-3 font-semibold">Category</th>
                        <th class="px-5 py-3 font-semibold">Price</th>
                        <th class="px-5 py-3 font-semibold">Availability</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0E6D8]">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-14 w-14 overflow-hidden rounded-lg bg-[#EAD7BD]">
                                        @if ($product->main_image)
                                            <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $product->name }}</p>
                                        <p class="text-xs text-[#6F665A]">{{ $product->slug }}</p>
                                        @if ($product->is_featured)
                                            <span class="mt-1 inline-flex rounded-full bg-[#D9A441]/20 px-2 py-1 text-xs font-semibold text-[#8B5E3C]">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $product->price ? 'Rs. '.number_format((float) $product->price, 2) : '-' }}</td>
                            <td class="px-5 py-4">{{ ucwords(str_replace('_', ' ', $product->availability)) }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $product->status === 'published' ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.show', $product) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#6F665A] hover:bg-[#FFF8EC]">View</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#8B5E3C] hover:bg-[#FFF8EC]">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product and all its images?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[#6F665A]">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $products->links() }}</div>
@endsection
