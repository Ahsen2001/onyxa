@php($companyName = setting('company_name', 'ONYXA Private Limited'))

<header class="sticky top-0 z-20 border-b border-[#E8DCCB] bg-white/90 px-5 py-4 backdrop-blur md:px-8">
    <div class="flex items-center justify-between gap-4">
        <div class="flex min-w-0 items-center gap-3">
            <button id="admin-sidebar-toggle" type="button" class="rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm font-semibold text-[#8B5E3C] lg:hidden">
                Menu
            </button>
            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-[#8B5E3C]">{{ $companyName }}</p>
                <h1 class="truncate text-2xl font-semibold tracking-tight">@yield('page-title', 'Dashboard')</h1>
            </div>
        </div>

        <div class="relative">
            <button id="admin-user-menu-toggle" type="button" class="flex items-center gap-3 rounded-full bg-[#FFF8EC] px-3 py-2 text-sm font-medium text-[#2E7D32] ring-1 ring-[#E8DCCB]">
                <span class="grid h-8 w-8 place-items-center rounded-full bg-[#2E7D32] text-xs font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </span>
                <span class="hidden max-w-32 truncate sm:inline">{{ auth()->user()->name ?? 'Admin' }}</span>
            </button>

            <div id="admin-user-menu" class="absolute right-0 mt-2 hidden w-56 overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-xl">
                <div class="border-b border-[#F0E6D8] px-4 py-3">
                    <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="truncate text-xs text-[#6F665A]">{{ auth()->user()->email ?? '' }}</p>
                </div>
                <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-3 text-sm text-[#2B2B2B] hover:bg-[#FFF8EC]">Profile</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-3 text-left text-sm text-red-700 hover:bg-red-50">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>
