<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - ONYXA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F7F3EA] text-[#2B2B2B] antialiased">
    <div id="admin-sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden"></div>

    <div class="min-h-screen lg:flex">
        @include('admin.partials.sidebar')

        <main class="flex min-w-0 flex-1 flex-col lg:ml-72">
            @include('admin.partials.topbar')

            <div class="px-5 py-6 md:px-8">
                @if (session('success'))
                    <x-ui.alert class="mb-5">{{ session('success') }}</x-ui.alert>
                @endif

                @if (session('error'))
                    <x-ui.alert type="error" class="mb-5">{{ session('error') }}</x-ui.alert>
                @endif

                @if ($errors->any())
                    <x-ui.alert type="error" class="mb-5">
                        <p class="font-semibold">Please fix the following:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-ui.alert>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        (() => {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const toggle = document.getElementById('admin-sidebar-toggle');
            const close = document.getElementById('admin-sidebar-close');
            const userToggle = document.getElementById('admin-user-menu-toggle');
            const userMenu = document.getElementById('admin-user-menu');

            const openSidebar = () => {
                sidebar?.classList.remove('-translate-x-full');
                overlay?.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar?.classList.add('-translate-x-full');
                overlay?.classList.add('hidden');
            };

            toggle?.addEventListener('click', openSidebar);
            close?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);

            userToggle?.addEventListener('click', () => {
                userMenu?.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (! userToggle?.contains(event.target) && ! userMenu?.contains(event.target)) {
                    userMenu?.classList.add('hidden');
                }
            });
        })();
    </script>
</body>
</html>
