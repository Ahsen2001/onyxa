<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'customer_name',
        'company_name',
        'position',
        'message',
        'image',
        'rating',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}
