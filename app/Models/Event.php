<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'location',
        'event_date',
        'event_time',
        'featured_image',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', 'upcoming')->whereDate('event_date', '>=', now()->toDateString());
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }
}
