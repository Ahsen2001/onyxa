<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ONYXA Private Limited')</title>
    <meta name="description" content="@yield('meta_description', 'ONYXA Private Limited creates modern coconut shell handicrafts from natural materials.')">
    @php($favicon = setting('favicon'))
    @if ($favicon)
        <link rel="icon" href="{{ asset('storage/'.$favicon) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFF8EC] font-sans text-[#2B2B2B] antialiased">
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
