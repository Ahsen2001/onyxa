<?php

use App\Models\Page;
use App\Models\SeoMeta;
use App\Models\Setting;
use App\Support\HtmlSanitizer;

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

if (! function_exists('rich_text')) {
    function rich_text(?string $html): string
    {
        if (! $html) {
            return '';
        }

        if ($html === strip_tags($html)) {
            return nl2br(e($html));
        }

        return HtmlSanitizer::clean($html) ?: '';
    }
}

if (! function_exists('safe_json_ld')) {
    function safe_json_ld(?string $json): ?string
    {
        if (! $json) {
            return null;
        }

        json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return preg_replace('/<\/script/i', '<\/script', $json);
    }
}

if (! function_exists('safe_google_map_embed')) {
    function safe_google_map_embed(?string $html, string $default): string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return $default;
        }

        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML('<!doctype html><html><body>'.$html.'</body></html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $iframe = $document->getElementsByTagName('iframe')->item(0);

        if (! $iframe instanceof DOMElement) {
            return $default;
        }

        $src = trim($iframe->getAttribute('src'));
        $host = strtolower((string) parse_url($src, PHP_URL_HOST));
        $path = (string) parse_url($src, PHP_URL_PATH);

        if (! in_array($host, ['www.google.com', 'google.com'], true) || ! str_starts_with($path, '/maps/embed')) {
            return $default;
        }

        return sprintf(
            '<iframe src="%s" width="600" height="450" class="h-72 w-full rounded-lg border-0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            e($src)
        );
    }
}

if (! function_exists('seo_context')) {
    function seo_context(): array
    {
        $route = request()->route();
        $routeName = $route?->getName();

        return match ($routeName) {
            'home' => ['home', null],
            'about' => ['about', null],
            'products.index' => ['products', null],
            'products.show' => ['product_detail', seo_route_model_id($route?->parameter('product'))],
            'news.index' => ['news', null],
            'news.show' => ['news_detail', seo_route_model_id($route?->parameter('news'))],
            'events.index' => ['events', null],
            'events.show' => ['event_detail', seo_route_model_id($route?->parameter('event'))],
            'gallery.index' => ['gallery', null],
            'testimonials.index' => ['testimonials', null],
            'contact' => ['contact', null],
            default => [null, null],
        };
    }
}

if (! function_exists('seo_route_model_id')) {
    function seo_route_model_id(mixed $model): ?int
    {
        if (is_object($model) && method_exists($model, 'getKey')) {
            return (int) $model->getKey();
        }

        return is_numeric($model) ? (int) $model : null;
    }
}

if (! function_exists('seo_meta')) {
    function seo_meta(array $defaults = []): array
    {
        [$pageType, $pageId] = seo_context();

        $record = null;

        if ($pageType) {
            $record = SeoMeta::query()
                ->where('page_type', $pageType)
                ->when($pageId, fn ($query) => $query->where('page_id', $pageId), fn ($query) => $query->whereNull('page_id'))
                ->first();
        }

        $metaTitle = $record?->meta_title ?: ($defaults['meta_title'] ?? setting('company_name', 'ONYXA Private Limited'));
        $metaDescription = $record?->meta_description ?: ($defaults['meta_description'] ?? 'ONYXA Private Limited creates modern coconut shell handicrafts from natural materials.');
        $ogTitle = $record?->og_title ?: ($defaults['og_title'] ?? $metaTitle) ?: $metaTitle;
        $ogDescription = $record?->og_description ?: ($defaults['og_description'] ?? $metaDescription) ?: $metaDescription;
        $ogImage = $record?->ogImageUrl() ?: ($defaults['og_image'] ?? asset('logo.png'));

        return [
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $record?->meta_keywords ?: ($defaults['meta_keywords'] ?? null),
            'og_title' => $ogTitle,
            'og_description' => $ogDescription,
            'og_image' => $ogImage,
            'canonical_url' => $record?->canonical_url ?: ($defaults['canonical_url'] ?? url()->current()),
            'robots' => $record?->robots ?: ($defaults['robots'] ?? 'index, follow'),
            'schema_json_ld' => safe_json_ld($record?->schema_json_ld ?: ($defaults['schema_json_ld'] ?? null)),
        ];
    }
}
