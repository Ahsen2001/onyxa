@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
    <section class="mb-6 grid gap-4 sm:grid-cols-3">
        <x-ui.admin-card title="All Messages" :value="$counts['all']" />
        <x-ui.admin-card title="Unread" :value="$counts['unread']" />
        <x-ui.admin-card title="Read" :value="$counts['read']" />
    </section>

    <section class="mb-5 rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="grid gap-4 lg:grid-cols-[1fr_auto_auto]">
            <input name="search" value="{{ $search }}" placeholder="Search by name, email, or subject" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">

            <select name="status" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                <option value="">All messages</option>
                <option value="unread" @selected($status === 'unread')>Unread</option>
                <option value="read" @selected($status === 'read')>Read</option>
            </select>

            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white hover:bg-[#70492F]">Filter</button>
                <a href="{{ route('admin.contact-messages.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Reset</a>
            </div>
        </form>
    </section>

    <x-ui.table>
        <thead class="bg-[#FFF8EC] text-left text-[#6F665A]">
            <tr>
                <th class="px-5 py-3">Sender</th>
                <th class="px-5 py-3">Subject</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3">Date</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#F0E6D8]">
            @forelse ($messages as $message)
                <tr class="{{ $message->is_read ? 'bg-white' : 'bg-[#2E7D32]/5' }}">
                    <td class="px-5 py-4">
                        <p class="font-semibold">{{ $message->name }}</p>
                        <p class="text-xs text-[#6F665A]">{{ $message->email }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-medium">{{ $message->subject ?: 'Contact inquiry' }}</p>
                        <p class="mt-1 max-w-md truncate text-xs text-[#6F665A]">{{ $message->message }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <x-ui.status-badge :status="$message->is_read ? 'read' : 'unread'" />
                    </td>
                    <td class="px-5 py-4 text-[#6F665A]">{{ $message->created_at->format('M d, Y h:i A') }}</td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap justify-end gap-2">
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm font-semibold text-[#8B5E3C]">View</a>

                            @if (! $message->is_read)
                                <form method="POST" action="{{ route('admin.contact-messages.read', $message) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Mark this message as read?')" class="rounded-lg border border-[#2E7D32]/20 px-3 py-2 text-sm font-semibold text-[#2E7D32]">Mark Read</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.contact-messages.unread', $message) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Mark this message as unread?')" class="rounded-lg border border-[#D9A441]/30 px-3 py-2 text-sm font-semibold text-[#8A641E]">Mark Unread</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-[#6F665A]">No contact messages found.</td>
                </tr>
            @endforelse
        </tbody>
    </x-ui.table>

    <div class="mt-5">{{ $messages->links() }}</div>
@endsection
