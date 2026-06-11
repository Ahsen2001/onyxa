<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - ONYXA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFF8EC] text-[#2B2B2B] antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-12">
        <section class="w-full max-w-md rounded-2xl border border-[#E8DCCB] bg-white p-8 shadow-sm">
            <div class="mb-8 text-center">
                <img src="{{ asset('logo.jpg') }}" alt="ONYXA logo" class="mx-auto h-16 w-16 rounded-full object-cover ring-2 ring-[#D9A441]">
                <h1 class="mt-4 text-2xl font-semibold">Admin Login</h1>
                <p class="mt-2 text-sm text-[#6F665A]">Access ONYXA content management.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="grid gap-5">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold">Password</label>
                    <input type="password" name="password" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                </div>
                <label class="flex items-center gap-3 text-sm text-[#6F665A]">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-[#DCC9AD]">
                    Remember me
                </label>
                <button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white hover:bg-[#724A2E]">Login</button>
            </form>
        </section>
    </main>
</body>
</html>
