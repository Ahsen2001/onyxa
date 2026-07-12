@extends('layouts.admin')

@section('title', 'SEO Meta')
@section('page-title', 'SEO Meta')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-[#6F665A]">Manage meta tags, Open Graph data, canonical URLs, robots meta, and Schema JSON-LD.</p>
            <p class="mt-1 text-sm text-[#6F665A]">Use Page ID only for product, news, and event detail pages.</p>
        </div>
        <a href="{{ route('admin.seo-meta.create') }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Add SEO Meta</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
                <thead class="bg-[#FFF8EC] text-left text-[#6F665A]">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Page</th>
                        <th class="px-5 py-3 font-semibold">Meta Title</th>
                        <th class="px-5 py-3 font-semibold">Robots</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0E6D8]">
                    @forelse ($seoMeta as $meta)
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-semibold">{{ $meta->pageTypeLabel() }}</p>
                                <p class="text-xs text-[#6F665A]">Page ID: {{ $meta->page_id ?? 'Static' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="line-clamp-2 max-w-lg">{{ $meta->meta_title ?: '-' }}</p>
                                <p class="mt-1 line-clamp-1 max-w-lg text-xs text-[#6F665A]">{{ $meta->meta_description }}</p>
                            </td>
                            <td class="px-5 py-4">{{ $meta->robots }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('admin.seo-meta.edit', $meta) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#8B5E3C] hover:bg-[#FFF8EC]">Edit</a>
                                    <form method="POST" action="{{ route('admin.seo-meta.destroy', $meta) }}" onsubmit="return confirm('Delete this SEO meta record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-[#6F665A]">No SEO meta records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $seoMeta->links() }}</div>
@endsection
