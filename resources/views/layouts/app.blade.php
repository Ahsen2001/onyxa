<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $metaTitle = trim($__env->yieldContent('title', setting('company_name', 'ONYXA Private Limited')));
        $metaDescription = trim($__env->yieldContent('meta_description', 'ONYXA Private Limited creates modern coconut shell handicrafts from natural materials.'));
        $canonicalUrl = trim($__env->yieldContent('canonical', url()->current()));
        $ogImage = trim($__env->yieldContent('og_image', asset('logo.jpg')));
        $ogType = trim($__env->yieldContent('og_type', 'website'));
    @endphp
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="{{ setting('company_name', 'ONYXA Private Limited') }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
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
