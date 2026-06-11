<?php

use App\Models\Page;
use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return cache()->remember("setting:{$key}", 300, fn () => Setting::valueFor($key, $default));
    }
}

if (! function_exists('page_section')) {
    function page_section(string $pageKey, string $sectionKey, string $field = 'content', mixed $default = null): mixed
    {
        $page = Page::query()
            ->where('page_key', $pageKey)
            ->where('section_key', $sectionKey)
            ->where('status', 'published')
            ->first();

        return $page?->{$field} ?: $default;
    }
}
