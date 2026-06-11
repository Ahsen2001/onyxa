<header class="sticky top-0 z-40 border-b border-[#E8DCCB] bg-[#FFF8EC]/95 backdrop-blur">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-20 items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @php($logo = setting('logo'))
                <img src="{{ $logo ? asset('storage/'.$logo) : asset('logo.jpg') }}" alt="ONYXA logo" class="h-12 w-12 rounded-full object-cover ring-2 ring-[#D9A441]">
                <div>
                    <p class="text-lg font-semibold leading-tight text-[#2B2B2B]">{{ setting('company_name', 'ONYXA') }}</p>
                    <p class="text-xs font-medium uppercase tracking-[0.18em] text-[#8B5E3C]">{{ setting('tagline', 'Private Limited') }}</p>
                </div>
            </a>

            <input id="nav-toggle" type="checkbox" class="peer hidden">
            <label for="nav-toggle" class="rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm font-semibold text-[#8B5E3C] lg:hidden">
                Menu
            </label>

            <div class="absolute left-0 right-0 top-20 hidden border-b border-[#E8DCCB] bg-[#FFF8EC] px-4 py-4 shadow-sm peer-checked:block lg:static lg:block lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">
                <div class="flex flex-col gap-1 lg:flex-row lg:items-center lg:gap-2">
                    @foreach ([
                        ['label' => 'Home', 'route' => 'home'],
                        ['label' => 'About Us', 'route' => 'about'],
                        ['label' => 'Products', 'route' => 'products.index'],
                        ['label' => 'News', 'route' => 'news.index'],
                        ['label' => 'Events', 'route' => 'events.index'],
                        ['label' => 'Gallery', 'route' => 'gallery.index'],
                        ['label' => 'Sustainability', 'route' => 'sustainability'],
                        ['label' => 'Contact', 'route' => 'contact'],
                    ] as $link)
                        <a href="{{ route($link['route']) }}"
                           class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs($link['route']) ? 'bg-[#8B5E3C] text-white' : 'text-[#2B2B2B] hover:bg-[#F0E4D2] hover:text-[#8B5E3C]' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>
</header>
