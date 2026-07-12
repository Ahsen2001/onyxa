@extends('layouts.admin')

@section('title', 'Trusted Clients')
@section('page-title', 'Trusted Clients')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-[#6F665A]">Upload, order, activate, and manage trusted client logos.</p>
        <a href="{{ route('admin.clients.create') }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Add Client Logo</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
                <thead class="bg-[#FFF8EC] text-left text-[#6F665A]">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Client</th>
                        <th class="px-5 py-3 font-semibold">Website</th>
                        <th class="px-5 py-3 font-semibold">Order</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0E6D8]">
                    @forelse ($clients as $client)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-14 w-20 place-items-center rounded-lg border border-[#E8DCCB] bg-[#FFF8EC] p-2">
                                        @if ($client->logo)
                                            <img src="{{ asset('storage/'.$client->logo) }}" alt="{{ $client->company_name }}" class="max-h-10 max-w-full object-contain">
                                        @else
                                            <span class="text-xs font-bold text-[#8B5E3C]">{{ str($client->company_name)->substr(0, 2)->upper() }}</span>
                                        @endif
                                    </span>
                                    <div>
                                        <p class="font-semibold">{{ $client->company_name }}</p>
                                        <p class="text-xs text-[#6F665A]">{{ $client->logo ?: 'No logo uploaded' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                @if ($client->website_url)
                                    <a href="{{ $client->website_url }}" target="_blank" rel="noopener" class="font-medium text-[#8B5E3C] hover:underline">{{ str($client->website_url)->limit(36) }}</a>
                                @else
                                    <span class="text-[#6F665A]">Not set</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">{{ $client->sort_order }}</td>
                            <td class="px-5 py-4"><x-ui.status-badge :status="$client->status" /></td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.clients.status', $client) }}" onsubmit="return confirm('Change client status?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $client->status === 'active' ? 'inactive' : 'active' }}">
                                        <button class="rounded-lg border border-[#2E7D32]/20 px-3 py-2 font-medium text-[#2E7D32] hover:bg-[#2E7D32]/10">{{ $client->status === 'active' ? 'Deactivate' : 'Activate' }}</button>
                                    </form>
                                    <a href="{{ route('admin.clients.edit', $client) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#8B5E3C] hover:bg-[#FFF8EC]">Edit</a>
                                    <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Delete this client logo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-[#6F665A]">No client logos found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $clients->links() }}</div>
@endsection
