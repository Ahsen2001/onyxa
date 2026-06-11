@extends('layouts.admin')

@section('title', 'Profile')
@section('page-title', 'Admin Profile')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <section class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#8B5E3C]">Signed in as</p>
            <h2 class="mt-3 text-2xl font-semibold">{{ $admin->name }}</h2>
            <p class="mt-2 text-sm text-[#6F665A]">{{ $admin->email }}</p>
            <div class="mt-6 rounded-lg bg-[#FFF8EC] p-4 text-sm leading-6 text-[#5F584F]">
                Keep this profile email accurate. It is used for admin login and content ownership across news and event records.
            </div>
        </section>

        <section class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="name" class="text-sm font-semibold text-[#2B2B2B]">Name</label>
                        <input id="name" name="name" value="{{ old('name', $admin->name) }}" required class="mt-2 w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                    </div>

                    <div>
                        <label for="email" class="text-sm font-semibold text-[#2B2B2B]">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $admin->email) }}" required class="mt-2 w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                    </div>
                </div>

                <div class="border-t border-[#F0E6D8] pt-6">
                    <h3 class="text-lg font-semibold">Change password</h3>
                    <p class="mt-1 text-sm text-[#6F665A]">Leave these fields empty if you only want to update profile details.</p>

                    <div class="mt-5 grid gap-5 md:grid-cols-3">
                        <div>
                            <label for="current_password" class="text-sm font-semibold text-[#2B2B2B]">Current password</label>
                            <input id="current_password" type="password" name="current_password" autocomplete="current-password" class="mt-2 w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                        </div>

                        <div>
                            <label for="password" class="text-sm font-semibold text-[#2B2B2B]">New password</label>
                            <input id="password" type="password" name="password" autocomplete="new-password" class="mt-2 w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                        </div>

                        <div>
                            <label for="password_confirmation" class="text-sm font-semibold text-[#2B2B2B]">Confirm password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="mt-2 w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#70492F]">
                        Save Profile
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
