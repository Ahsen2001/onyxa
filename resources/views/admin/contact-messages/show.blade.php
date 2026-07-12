@extends('layouts.admin')

@section('title', 'Message from '.$contactMessage->name)
@section('page-title', 'Contact Message Details')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.contact-messages.index') }}" class="rounded-lg border border-[#DCC9AD] px-4 py-2 text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC] transition inline-flex items-center gap-1.5">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to messages
        </a>

        <div class="flex flex-wrap gap-2">
            @if ($contactMessage->status !== 'closed')
                <form method="POST" action="{{ route('admin.contact-messages.status', $contactMessage) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="closed">
                    <button type="submit" onclick="return confirm('Close this inquiry?')" class="rounded-lg bg-slate-600 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700 transition">Close Inquiry</button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.contact-messages.status', $contactMessage) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="reading">
                    <button type="submit" onclick="return confirm('Reopen this inquiry?')" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">Reopen Inquiry</button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" onsubmit="return confirm('Delete this message permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-100 transition">Delete Message</button>
            </form>
        </div>
    </div>

    @if($errors->has('reply_error'))
        <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
            {{ $errors->first('reply_error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-5 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main Panel (Left 2 cols) -->
        <div class="space-y-6 lg:col-span-2">
            <!-- Message card -->
            <article class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between gap-3 border-b border-[#F0E6D8] pb-5">
                    <div>
                        <h2 class="text-xl font-bold text-[#2B2B2B] sm:text-2xl">{{ $contactMessage->subject ?: 'Contact inquiry' }}</h2>
                        <p class="mt-1 text-xs text-[#6F665A]">Received {{ $contactMessage->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-ui.status-badge :status="$contactMessage->status" />
                    </div>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-lg bg-[#FFF8EC]/60 p-4 border border-[#F0E6D8]/50">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-[#8B5E3C]">Name</dt>
                        <dd class="mt-1 font-bold text-[#2B2B2B]">{{ $contactMessage->name }}</dd>
                    </div>
                    <div class="rounded-lg bg-[#FFF8EC]/60 p-4 border border-[#F0E6D8]/50">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-[#8B5E3C]">Email</dt>
                        <dd class="mt-1 font-bold">
                            <a href="mailto:{{ $contactMessage->email }}" class="text-[#8B5E3C] hover:underline">{{ $contactMessage->email }}</a>
                        </dd>
                    </div>
                    <div class="rounded-lg bg-[#FFF8EC]/60 p-4 border border-[#F0E6D8]/50">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-[#8B5E3C]">Phone</dt>
                        <dd class="mt-1 font-bold text-[#2B2B2B]">{{ $contactMessage->phone ?? '-' }}</dd>
                    </div>
                    <div class="rounded-lg bg-[#FFF8EC]/60 p-4 border border-[#F0E6D8]/50">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-[#8B5E3C]">IP Address</dt>
                        <dd class="mt-1 font-bold text-[#2B2B2B]">{{ $contactMessage->ip_address ?? '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <h3 class="font-bold text-[#2B2B2B] border-b border-[#F0E6D8] pb-2">User Message</h3>
                    <div class="mt-3 whitespace-pre-line rounded-xl border border-[#F0E6D8] bg-[#FFF8EC]/10 p-5 leading-relaxed text-[#5F584F] text-sm">
                        {{ $contactMessage->message }}
                    </div>
                </div>
            </article>

            <!-- Reply Card -->
            <section class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-[#2B2B2B] border-b border-[#F0E6D8] pb-3 mb-4 inline-flex items-center gap-1.5">
                    <svg class="h-5 w-5 text-[#8B5E3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Reply via Email
                </h3>

                @if($contactMessage->status === 'replied')
                    <div class="mb-5 rounded-lg bg-emerald-50/50 border border-emerald-100 p-4 text-xs text-emerald-800">
                        <strong>Note:</strong> A reply email has already been sent to this user on 
                        {{ $contactMessage->replied_at?->format('M d, Y \a\t h:i A') ?? 'N/A' }}. 
                        You can send another reply if needed.
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.contact-messages.reply', $contactMessage) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="reply_subject" class="block text-xs font-bold uppercase tracking-wider text-[#6F665A] mb-1.5">Email Subject</label>
                        <input type="text" name="reply_subject" id="reply_subject" required 
                               value="{{ old('reply_subject', 'Re: ' . ($contactMessage->subject ?: 'Contact Inquiry')) }}" 
                               class="w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-2.5 text-sm outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15 transition">
                        @error('reply_subject')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reply_message" class="block text-xs font-bold uppercase tracking-wider text-[#6F665A] mb-1.5">Reply Message</label>
                        <textarea name="reply_message" id="reply_message" rows="8" required placeholder="Type your response to the user here..."
                                  class="w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-2.5 text-sm outline-none focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15 transition">{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-lg bg-[#8B5E3C] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#70492F] transition shadow-sm">
                            Send Reply Email
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <!-- Sidebar Panel (Right 1 col) -->
        <div class="space-y-6">
            <!-- Status card -->
            <div class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#6F665A] border-b border-[#F0E6D8] pb-2 mb-4">Inquiry Status</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-[#6F665A]">Current Status:</span>
                        <x-ui.status-badge :status="$contactMessage->status" />
                    </div>
                    
                    <form method="POST" action="{{ route('admin.contact-messages.status', $contactMessage) }}" class="pt-4 border-t border-[#F0E6D8] space-y-3">
                        @csrf
                        @method('PATCH')
                        <label for="status-select" class="block text-xs font-bold uppercase tracking-wider text-[#6F665A]">Change Status</label>
                        <div class="flex gap-2">
                            <select name="status" id="status-select" class="flex-1 rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm outline-none focus:border-[#8B5E3C] focus:ring-1 focus:ring-[#8B5E3C] transition">
                                <option value="new" @selected($contactMessage->status === 'new')>New</option>
                                <option value="reading" @selected($contactMessage->status === 'reading')>Reading</option>
                                <option value="replied" @selected($contactMessage->status === 'replied')>Replied</option>
                                <option value="closed" @selected($contactMessage->status === 'closed')>Closed</option>
                            </select>
                            <button type="submit" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#70492F] transition shadow-sm">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notes card -->
            <div class="rounded-xl border border-[#E8DCCB] bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#6F665A] border-b border-[#F0E6D8] pb-2 mb-4 inline-flex items-center gap-1">
                    <svg class="h-4 w-4 text-[#8B5E3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Internal Notes
                </h3>
                <form method="POST" action="{{ route('admin.contact-messages.notes', $contactMessage) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <textarea name="internal_notes" rows="6" placeholder="Write internal notes about this user, phone calls, progress, etc. (Admins only)..."
                                  class="w-full rounded-lg border border-[#DCC9AD] bg-white px-3 py-2 text-xs outline-none focus:border-[#8B5E3C] focus:ring-1 focus:ring-[#8B5E3C] transition leading-relaxed text-[#5F584F]">{{ old('internal_notes', $contactMessage->internal_notes) }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="rounded-lg bg-[#2E7D32] px-4 py-2 text-xs font-semibold text-white hover:bg-[#225C25] transition shadow-sm">
                            Save Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
