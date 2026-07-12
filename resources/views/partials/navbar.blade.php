<header class="sticky top-0 z-40 border-b border-[#E8DCCB] bg-[#FFF8EC]/95 backdrop-blur">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-28 flex-wrap items-center justify-between gap-3 py-3">
            <a href="{{ route('home') }}" class="flex min-w-0 flex-1 items-center gap-3 sm:gap-4">
                @php($logo = setting('logo'))
                <img src="{{ $logo ? asset('storage/'.$logo) : asset('logo.png') }}" alt="ONYXA logo" class="h-20 w-20 shrink-0 rounded-full bg-white p-1.5 object-contain ring-2 ring-[#D9A441] sm:h-24 sm:w-24 lg:h-20 lg:w-20">
                <div class="min-w-0 flex-1">
                    <p class="text-xl font-semibold leading-tight text-[#2B2B2B] sm:text-2xl lg:text-3xl">{{ setting('company_name', 'ONYXA') }}</p>
                    <p class="mt-1 text-sm font-medium uppercase leading-snug tracking-[0.22em] text-[#8B5E3C] sm:text-base lg:text-lg">{{ setting('tagline', 'Private Limited') }}</p>
                </div>
            </a>

            <input id="nav-toggle" type="checkbox" class="peer hidden">
            <label for="nav-toggle" class="rounded-lg border border-[#DCC9AD] px-3 py-2 text-sm font-semibold text-[#8B5E3C] lg:hidden">
                Menu
            </label>

            <div class="absolute left-0 right-0 top-28 hidden border-b border-[#E8DCCB] bg-[#FFF8EC] px-4 py-4 shadow-sm peer-checked:block lg:static lg:block lg:basis-full lg:border-0 lg:bg-transparent lg:p-0 lg:pt-3 lg:shadow-none">
                <div class="flex flex-col gap-4 lg:flex-row lg:flex-wrap lg:items-center lg:justify-between lg:gap-3">
                    <div class="flex flex-col gap-1 lg:flex-row lg:flex-wrap lg:items-center lg:gap-1 xl:gap-2">
                        @foreach ([
                        ['label' => 'Home', 'route' => 'home'],
                        ['label' => 'About', 'route' => 'about'],
                        ['label' => 'Products', 'route' => 'products.index'],
                        ['label' => 'News', 'route' => 'news.index'],
                        ['label' => 'Events', 'route' => 'events.index'],
                        ['label' => 'Gallery', 'route' => 'gallery.index'],
                        ['label' => 'Testimonials', 'route' => 'testimonials.index'],
                        ['label' => 'Sustainability', 'route' => 'sustainability'],
                        ['label' => 'Contact', 'route' => 'contact'],
                        ] as $link)
                        <a href="{{ route($link['route']) }}"
                            class="whitespace-nowrap rounded-lg px-3 py-2 font-medium transition lg:text-sm {{ request()->routeIs($link['route']) ? 'bg-[#8B5E3C] text-white' : 'text-[#2B2B2B] hover:bg-[#F0E4D2] hover:text-[#8B5E3C]' }}">
                            {{ $link['label'] }}
                        </a>
                        @endforeach
                    </div>

                    <form action="{{ route('search') }}" method="GET" class="relative w-full max-w-xs shrink-0 lg:w-64 lg:max-w-none">
                        <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}" class="w-full rounded-lg border border-[#DCC9AD] bg-[#FFF8EC] py-1.5 pl-3 pr-8 text-sm focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15 focus:outline-none text-[#2B2B2B]">
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-2.5">
                            <svg class="h-4 w-4 text-[#8B5E3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>
