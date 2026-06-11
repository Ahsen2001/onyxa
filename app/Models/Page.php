<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'page_key',
        'section_key',
        'title',
        'slug',
        'content',
        'image',
        'featured_image',
        'meta_title',
        'meta_description',
        'status',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeKey(Builder $query, string $key): Builder
    {
        return $query->where('page_key', $key);
    }
}
