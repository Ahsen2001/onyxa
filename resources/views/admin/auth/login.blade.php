<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - ONYXA Private Limited</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFF8EC] text-[#2B2B2B] antialiased">
    @php($logo = setting('logo'))

    <main class="grid min-h-screen place-items-center px-4 py-10">
        <section class="w-full max-w-5xl overflow-hidden rounded-2xl border border-[#E8DCCB] bg-white shadow-soft md:grid md:grid-cols-[0.9fr_1.1fr]">
            <div class="bg-[#2B2B2B] p-8 text-white md:p-10">
                <img src="{{ $logo ? asset('storage/'.$logo) : asset('logo.jpg') }}" alt="ONYXA logo" class="h-16 w-16 rounded-full object-cover ring-2 ring-[#D9A441]">
                <p class="mt-8 text-sm font-semibold uppercase tracking-[0.18em] text-[#D9A441]">Admin access</p>
                <h1 class="mt-3 text-3xl font-semibold leading-tight">ONYXA content management</h1>
                <p class="mt-4 text-sm leading-7 text-white/70">
                    Sign in to manage coconut shell handicraft products, news, events, gallery images, messages, and website settings.
                </p>
                <div class="mt-8 rounded-xl border border-white/10 bg-white/5 p-4 text-sm text-white/70">
                    Use your assigned admin account and keep your password private.
                </div>
            </div>

            <div class="p-8 md:p-10">
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#2E7D32]">Secure login</p>
                    <h2 class="mt-2 text-2xl font-semibold">Welcome back</h2>
                </div>

                @if ($errors->any())
                    <x-ui.alert type="error" class="mb-5">{{ $errors->first() }}</x-ui.alert>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="text-sm font-semibold">Email address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="mt-2 w-full rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                    </div>

                    <div>
                        <label for="password" class="text-sm font-semibold">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-2 w-full rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm outline-none transition focus:border-[#8B5E3C] focus:ring-2 focus:ring-[#8B5E3C]/15">
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                        <label class="flex items-center gap-3 text-[#6F665A]">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-[#DCC9AD] text-[#8B5E3C]">
                            Remember me
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-semibold text-[#8B5E3C] hover:text-[#70492F]">Forgot password?</a>
                        @else
                            <span class="text-[#6F665A]">Contact the site owner for password help.</span>
                        @endif
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#70492F]">
                        Sign in
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
