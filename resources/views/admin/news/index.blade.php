@extends('layouts.admin')

@section('title', 'News')
@section('page-title', 'News')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-[#6F665A]">Create, edit, publish, and remove company news posts.</p>
        <a href="{{ route('admin.news.create') }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Add News</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
        <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
            <thead class="bg-[#FFF8EC] text-left text-[#6F665A]">
                <tr>
                    <th class="px-5 py-3 font-semibold">Post</th>
                    <th class="px-5 py-3 font-semibold">Date</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                    <th class="px-5 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F0E6D8]">
                @forelse ($news as $post)
                    <tr>
                        <td class="px-5 py-4">
                            <p class="font-semibold">{{ $post->title }}</p>
                            <p class="line-clamp-1 text-xs text-[#6F665A]">{{ $post->short_description }}</p>
                        </td>
                        <td class="px-5 py-4">{{ $post->published_at?->format('M d, Y') ?? '-' }}</td>
                        <td class="px-5 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $post->status === 'published' ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($post->status) }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.news.show', $post) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#6F665A] hover:bg-[#FFF8EC]">View</a>
                                <a href="{{ route('admin.news.edit', $post) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#8B5E3C] hover:bg-[#FFF8EC]">Edit</a>
                                <form method="POST" action="{{ route('admin.news.destroy', $post) }}" onsubmit="return confirm('Delete this news post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-700 hover:bg-red-50">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-[#6F665A]">No news posts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $news->links() }}</div>
@endsection
