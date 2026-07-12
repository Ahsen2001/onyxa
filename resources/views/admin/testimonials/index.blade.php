@extends('layouts.admin')

@section('title', 'Testimonials')
@section('page-title', 'Testimonials')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-[#6F665A]">Create, edit, activate, and remove customer testimonials.</p>
        <a href="{{ route('admin.testimonials.create') }}" class="rounded-lg bg-[#8B5E3C] px-4 py-2 text-sm font-semibold text-white hover:bg-[#724A2E]">Add Testimonial</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
                <thead class="bg-[#FFF8EC] text-left text-[#6F665A]">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Customer</th>
                        <th class="px-5 py-3 font-semibold">Rating</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0E6D8]">
                    @forelse ($testimonials as $testimonial)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($testimonial->image)
                                        <img src="{{ asset('storage/'.$testimonial->image) }}" alt="{{ $testimonial->customer_name }}" class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <span class="grid h-12 w-12 place-items-center rounded-full bg-[#2E7D32]/10 text-sm font-bold text-[#2E7D32]">{{ str($testimonial->customer_name)->substr(0, 1)->upper() }}</span>
                                    @endif
                                    <div>
                                        <p class="font-semibold">{{ $testimonial->customer_name }}</p>
                                        <p class="text-xs text-[#6F665A]">{{ collect([$testimonial->position, $testimonial->company_name])->filter()->join(', ') ?: 'Customer' }}</p>
                                        <p class="mt-1 line-clamp-1 max-w-xl text-xs text-[#6F665A]">{{ $testimonial->message }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">{{ $testimonial->rating }}/5</td>
                            <td class="px-5 py-4"><x-ui.status-badge :status="$testimonial->status" /></td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.testimonials.status', $testimonial) }}" onsubmit="return confirm('Change testimonial status?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $testimonial->status === 'active' ? 'inactive' : 'active' }}">
                                        <button class="rounded-lg border border-[#2E7D32]/20 px-3 py-2 font-medium text-[#2E7D32] hover:bg-[#2E7D32]/10">{{ $testimonial->status === 'active' ? 'Deactivate' : 'Activate' }}</button>
                                    </form>
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="rounded-lg border border-[#DCC9AD] px-3 py-2 font-medium text-[#8B5E3C] hover:bg-[#FFF8EC]">Edit</a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete this testimonial?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-200 px-3 py-2 font-medium text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-[#6F665A]">No testimonials found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $testimonials->links() }}</div>
@endsection
