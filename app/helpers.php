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

if (! function_exists('whatsapp_url')) {
    function whatsapp_url(?string $message = null, ?string $number = null): string
    {
        $number = $number ?: setting('whatsapp', setting('phone', ''));
        $number = preg_replace('/\D+/', '', (string) $number);
        $message = $message ?: 'Hello ONYXA Private Limited, I would like to know more about your coconut shell handicrafts.';

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }
}
