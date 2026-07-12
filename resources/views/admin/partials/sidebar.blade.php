@php
    $logo = setting('logo');
    $companyName = setting('company_name', 'ONYXA Private Limited');
    $tagline = setting('tagline', 'Admin Panel');
    $menu = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'Products', 'route' => 'admin.products.index', 'active' => 'admin.products.*'],
        ['label' => 'Categories', 'route' => 'admin.product-categories.index', 'active' => 'admin.product-categories.*'],
        ['label' => 'News', 'route' => 'admin.news.index', 'active' => 'admin.news.*'],
        ['label' => 'Events', 'route' => 'admin.events.index', 'active' => 'admin.events.*'],
        ['label' => 'Gallery', 'route' => 'admin.galleries.index', 'active' => 'admin.galleries.*'],
        ['label' => 'Gallery Categories', 'route' => 'admin.gallery-categories.index', 'active' => 'admin.gallery-categories.*'],
        ['label' => 'Media Library', 'route' => 'admin.media.index', 'active' => 'admin.media.*'],
        ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'active' => 'admin.testimonials.*'],
        ['label' => 'Messages', 'route' => 'admin.contact-messages.index', 'active' => 'admin.contact-messages.*'],
        ['label' => 'Pages', 'route' => 'admin.pages.index', 'active' => 'admin.pages.*'],
        ['label' => 'SEO Meta', 'route' => 'admin.seo-meta.index', 'active' => 'admin.seo-meta.*'],
        ['label' => 'Settings', 'route' => 'admin.settings.index', 'active' => 'admin.settings.*'],
        ['label' => 'Profile', 'route' => 'admin.profile.edit', 'active' => 'admin.profile.*'],
    ];
@endphp

<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col overflow-hidden bg-[#2B2B2B] px-4 py-5 text-white shadow-2xl transition-transform duration-200 lg:translate-x-0">
    <div class="shrink-0 flex items-center justify-between gap-3 px-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <img src="{{ $logo ? asset('storage/'.$logo) : asset('logo.png') }}" alt="{{ $companyName }} logo" class="h-14 w-14 shrink-0 rounded-full bg-white p-1 object-contain ring-2 ring-[#D9A441]">
            <div>
                <p class="max-w-44 truncate text-xs font-semibold uppercase tracking-[0.18em] text-[#D9A441]">{{ $companyName }}</p>
                <p class="max-w-44 truncate font-semibold">{{ $tagline }}</p>
            </div>
        </a>
        <button id="admin-sidebar-close" type="button" class="rounded-lg border border-white/15 px-3 py-2 text-sm text-white/75 lg:hidden">Close</button>
    </div>

    <nav class="mt-7 min-h-0 flex-1 overflow-y-auto pr-1 text-sm">
        <div class="grid gap-1 pb-4">
        @foreach ($menu as $item)
            <a href="{{ route($item['route']) }}"
               class="rounded-xl px-4 py-3 font-medium transition {{ request()->routeIs($item['active']) ? 'bg-[#8B5E3C] text-white shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
        </div>
    </nav>

    <form method="POST" action="{{ route('admin.logout') }}" class="shrink-0 pt-5">
        @csrf
        <button type="submit" class="w-full rounded-xl border border-white/15 px-4 py-3 text-left text-sm font-semibold text-white/75 transition hover:border-[#D9A441] hover:bg-[#D9A441] hover:text-[#2B2B2B]">
            Logout
        </button>
    </form>
</aside>
