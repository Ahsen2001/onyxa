<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $table = 'seo_meta';

    protected $fillable = [
        'page_type',
        'page_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'robots',
        'schema_json_ld',
    ];

    public static function pageTypes(): array
    {
        return [
            'home' => 'Home page',
            'about' => 'About page',
            'products' => 'Products listing',
            'product_detail' => 'Product details',
            'news' => 'News listing',
            'news_detail' => 'News details',
            'events' => 'Events listing',
            'event_detail' => 'Event details',
            'gallery' => 'Gallery',
            'testimonials' => 'Testimonials',
            'contact' => 'Contact page',
        ];
    }

    public static function detailPageTypes(): array
    {
        return ['product_detail', 'news_detail', 'event_detail'];
    }

    public static function staticPageTypes(): array
    {
        return array_values(array_diff(array_keys(self::pageTypes()), self::detailPageTypes()));
    }

    public function pageTypeLabel(): string
    {
        return self::pageTypes()[$this->page_type] ?? str($this->page_type)->headline()->toString();
    }

    public function ogImageUrl(): ?string
    {
        return $this->og_image ? asset('storage/'.$this->og_image) : null;
    }
}
