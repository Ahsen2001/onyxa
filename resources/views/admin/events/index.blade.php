@extends('layouts.admin')

@section('title', 'Events')
@section('page-title', 'Events')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-[#6F665A]">Manage upcoming, completed, and cancelled events.</p>
        <a href="{{ route('admin.events.create') }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Add Event</a>
    </div>
    <div class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
        <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
            <thead class="bg-[#FFF8EC] text-left text-[#6F665A]"><tr><th class="px-5 py-3">Event</th><th class="px-5 py-3">Date</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Actions</th></tr></thead>
            <tbody class="divide-y divide-[#F0E6D8]">
                @forelse ($events as $event)
                    <tr>
                        <td class="px-5 py-4"><p class="font-semibold">{{ $event->title }}</p><p class="text-xs text-[#6F665A]">{{ $event->location }}</p></td>
                        <td class="px-5 py-4">{{ $event->event_date?->format('M d, Y') }} @if($event->event_time) {{ substr($event->event_time, 0, 5) }} @endif</td>
                        <td class="px-5 py-4"><span class="rounded-full bg-[#2E7D32]/10 px-3 py-1 text-xs font-semibold text-[#2E7D32]">{{ ucfirst($event->status) }}</span></td>
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.events.show', $event) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#6F665A]">View</a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#8B5E3C]">Edit</a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?');">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-700">Delete</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-[#6F665A]">No events found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $events->links() }}</div>
@endsection
