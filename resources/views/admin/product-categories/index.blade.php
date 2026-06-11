@extends('layouts.admin')

@section('title', 'Product Categories')
@section('page-title', 'Product Categories')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-[#6F665A]">Manage product groupings for ONYXA handicrafts.</p>
        <a href="{{ route('admin.product-categories.create') }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Add Category</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
                <thead class="bg-[#FFF8EC] text-left text-[#6F665A]">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Category</th>
                        <th class="px-5 py-3 font-semibold">Slug</th>
                        <th class="px-5 py-3 font-semibold">Products</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0E6D8]">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-lg bg-[#EAD7BD]">
                                        @if ($category->image)
                                            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $category->name }}</p>
                                        <p class="line-clamp-1 text-xs text-[#6F665A]">{{ $category->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-[#6F665A]">{{ $category->slug }}</td>
                            <td class="px-5 py-4">{{ $category->products_count }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $category->status === 'active' ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($category->status) }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.product-categories.edit', $category) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#8B5E3C] hover:bg-[#FFF8EC]">Edit</a>
                                    <form method="POST" action="{{ route('admin.product-categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-[#6F665A]">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $categories->links() }}</div>
@endsection
