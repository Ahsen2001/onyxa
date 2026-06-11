@extends('layouts.admin')

@section('title', 'Message from '.$contactMessage->name)
@section('page-title', 'Contact Message')

@section('content')
    <article class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('admin.contact-messages.index') }}" class="rounded-lg border border-[#DCC9AD] px-4 py-2 text-sm font-semibold text-[#8B5E3C]">Back to messages</a>

            <div class="flex flex-wrap gap-2">
                @unless ($contactMessage->is_read)
                    <form method="POST" action="{{ route('admin.contact-messages.read', $contactMessage) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="rounded-lg bg-[#2E7D32] px-4 py-2 text-sm font-semibold text-white">Mark as read</button>
                    </form>
                @endunless

                <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" onsubmit="return confirm('Delete this message?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700">Delete</button>
                </form>
            </div>
        </div>

        <div class="mb-6 flex items-center justify-between gap-3 border-b border-[#F0E6D8] pb-5">
            <div>
                <h2 class="text-2xl font-semibold">{{ $contactMessage->subject ?: 'Contact inquiry' }}</h2>
                <p class="mt-1 text-sm text-[#6F665A]">Received {{ $contactMessage->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <x-ui.status-badge :status="$contactMessage->is_read ? 'read' : 'unread'" />
        </div>

        <dl class="grid gap-4 md:grid-cols-2">
            <div class="rounded-lg bg-[#FFF8EC] p-4">
                <dt class="text-sm text-[#6F665A]">Name</dt>
                <dd class="mt-1 font-semibold">{{ $contactMessage->name }}</dd>
            </div>
            <div class="rounded-lg bg-[#FFF8EC] p-4">
                <dt class="text-sm text-[#6F665A]">Email</dt>
                <dd class="mt-1 font-semibold">
                    <a href="mailto:{{ $contactMessage->email }}" class="text-[#8B5E3C]">{{ $contactMessage->email }}</a>
                </dd>
            </div>
            <div class="rounded-lg bg-[#FFF8EC] p-4">
                <dt class="text-sm text-[#6F665A]">Phone</dt>
                <dd class="mt-1 font-semibold">{{ $contactMessage->phone ?? '-' }}</dd>
            </div>
            <div class="rounded-lg bg-[#FFF8EC] p-4">
                <dt class="text-sm text-[#6F665A]">IP Address</dt>
                <dd class="mt-1 font-semibold">{{ $contactMessage->ip_address ?? '-' }}</dd>
            </div>
        </dl>

        <div class="mt-6">
            <h3 class="font-semibold">Message</h3>
            <p class="mt-3 whitespace-pre-line rounded-xl border border-[#F0E6D8] bg-white p-5 leading-8 text-[#5F584F]">{{ $contactMessage->message }}</p>
        </div>
    </article>
@endsection
