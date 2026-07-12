<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $seo = seo_meta([
            'meta_title' => trim($__env->yieldContent('title', setting('company_name', 'ONYXA Private Limited'))),
            'meta_description' => trim($__env->yieldContent('meta_description', 'ONYXA Private Limited creates modern coconut shell handicrafts from natural materials.')),
            'canonical_url' => trim($__env->yieldContent('canonical', url()->current())),
            'og_image' => trim($__env->yieldContent('og_image', asset('logo.png'))),
        ]);
        $metaTitle = $seo['meta_title'];
        $metaDescription = $seo['meta_description'];
        $canonicalUrl = $seo['canonical_url'];
        $ogImage = $seo['og_image'];
        $ogType = trim($__env->yieldContent('og_type', 'website'));
    @endphp
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if ($seo['meta_keywords'])
        <meta name="keywords" content="{{ $seo['meta_keywords'] }}">
    @endif
    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="{{ setting('company_name', 'ONYXA Private Limited') }}">
    <meta property="og:title" content="{{ $seo['og_title'] }}">
    <meta property="og:description" content="{{ $seo['og_description'] }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['og_title'] }}">
    <meta name="twitter:description" content="{{ $seo['og_description'] }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    @if ($seo['schema_json_ld'])
        <script type="application/ld+json">{!! $seo['schema_json_ld'] !!}</script>
    @endif
    @php($favicon = setting('favicon'))
    <link rel="icon" type="image/png" href="{{ $favicon ? asset('storage/'.$favicon) : asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ $favicon ? asset('storage/'.$favicon) : asset('logo.png') }}">
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
