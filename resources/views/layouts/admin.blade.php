<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - ONYXA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F7F3EA] text-[#2B2B2B] antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="border-b border-[#E8DCCB] bg-[#2B2B2B] text-white lg:fixed lg:inset-y-0 lg:left-0 lg:w-72 lg:border-b-0">
            <div class="flex items-center gap-3 px-6 py-5">
                <img src="{{ asset('logo.jpg') }}" alt="ONYXA logo" class="h-12 w-12 rounded-full object-cover ring-2 ring-[#D9A441]">
                <div>
                    <p class="text-sm uppercase tracking-[0.18em] text-[#D9A441]">ONYXA</p>
                    <p class="font-semibold">Admin Panel</p>
                </div>
            </div>

            <nav class="grid gap-1 px-4 pb-5 text-sm lg:pb-8">
                @php
                    $menu = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
                        ['label' => 'Products', 'route' => 'admin.products.index'],
                        ['label' => 'Categories', 'route' => 'admin.product-categories.index'],
                        ['label' => 'News', 'route' => 'admin.news.index'],
                        ['label' => 'Events', 'route' => 'admin.events.index'],
                        ['label' => 'Gallery', 'route' => 'admin.galleries.index'],
                        ['label' => 'Gallery Categories', 'route' => 'admin.gallery-categories.index'],
                        ['label' => 'Messages', 'route' => 'admin.contact-messages.index'],
                        ['label' => 'Pages', 'route' => 'admin.pages.index'],
                        ['label' => 'Settings', 'route' => 'admin.settings.index'],
                        ['label' => 'Profile', 'route' => 'admin.profile'],
                    ];
                @endphp

                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}"
                       class="rounded-lg px-4 py-3 transition {{ request()->routeIs($item['route']) ? 'bg-[#8B5E3C] text-white shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <form method="POST" action="{{ route('admin.logout') }}" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full rounded-lg border border-white/15 px-4 py-3 text-left text-white/75 transition hover:border-[#D9A441] hover:bg-[#D9A441] hover:text-[#2B2B2B]">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 lg:ml-72">
            <header class="border-b border-[#E8DCCB] bg-white/80 px-5 py-4 backdrop-blur md:px-8">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-[#8B5E3C]">ONYXA Private Limited</p>
                        <h1 class="text-2xl font-semibold tracking-tight">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="rounded-full bg-[#FFF8EC] px-4 py-2 text-sm font-medium text-[#2E7D32]">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>
                </div>
            </header>

            <div class="px-5 py-6 md:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
