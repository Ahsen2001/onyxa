@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
    <section class="mb-6 grid gap-4 grid-cols-2 lg:grid-cols-5">
        <x-ui.admin-card title="All Messages" :value="$counts['all']" />
        <x-ui.admin-card title="New" :value="$counts['new']" />
        <x-ui.admin-card title="Reading" :value="$counts['reading']" />
        <x-ui.admin-card title="Replied" :value="$counts['replied']" />
        <x-ui.admin-card title="Closed" :value="$counts['closed']" />
    </section>

    <section class="mb-5 rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="grid gap-4 lg:grid-cols-[1fr_200px_auto]">
            <input name="search" value="{{ $search }}" placeholder="Search by name, email, subject, phone, message or notes..." class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">

            <select name="status" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                <option value="">All statuses</option>
                <option value="new" @selected($status === 'new')>New</option>
                <option value="reading" @selected($status === 'reading')>Reading</option>
                <option value="replied" @selected($status === 'replied')>Replied</option>
                <option value="closed" @selected($status === 'closed')>Closed</option>
            </select>

            <div class="flex flex-wrap gap-2">
                <button type="submit" class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white hover:bg-[#70492F]">Filter</button>
                <a href="{{ route('admin.contact-messages.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC] text-center">Reset</a>
                <a href="{{ route('admin.contact-messages.export', request()->query()) }}" class="rounded-lg bg-[#2E7D32] px-5 py-3 text-sm font-semibold text-white hover:bg-[#225C25] text-center inline-flex items-center gap-1">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export CSV
                </a>
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
                <tr class="{{ $message->status === 'new' ? 'bg-[#D9A441]/5 font-semibold text-[#2B2B2B]' : 'bg-white text-[#5F584F]' }}">
                    <td class="px-5 py-4">
                        <p class="font-bold text-[#2B2B2B]">{{ $message->name }}</p>
                        <p class="text-xs text-[#6F665A]">{{ $message->email }}</p>
                        @if($message->phone)
                            <p class="text-[10px] text-[#8B5E3C]">{{ $message->phone }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-medium text-[#2B2B2B]">{{ $message->subject ?: 'Contact inquiry' }}</p>
                        <p class="mt-1 max-w-md truncate text-xs text-[#6F665A]">{{ $message->message }}</p>
                        @if($message->internal_notes)
                            <p class="mt-1 text-[10px] text-blue-600 truncate max-w-md"><span class="font-semibold text-blue-800">Note:</span> {{ $message->internal_notes }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <x-ui.status-badge :status="$message->status" />
                    </td>
                    <td class="px-5 py-4 text-[#6F665A] text-xs">
                        {{ $message->created_at->format('M d, Y') }}
                        <span class="block text-[10px] text-[#8B5E3C]">{{ $message->created_at->format('h:i A') }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap justify-end gap-2">
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC]">View</a>

                            @if ($message->status !== 'closed')
                                <form method="POST" action="{{ route('admin.contact-messages.status', $message) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="closed">
                                    <button type="submit" onclick="return confirm('Close this message inquiry?')" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Close</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.contact-messages.status', $message) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="reading">
                                    <button type="submit" onclick="return confirm('Reopen this message inquiry?')" class="rounded-lg border border-blue-200 px-3 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50">Reopen</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-100 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">Delete</button>
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
