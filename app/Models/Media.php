<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'alt_text',
        'uploaded_by',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopeImages(Builder $query): Builder
    {
        return $query->where('file_type', 'like', 'image/%');
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search): void {
            $query->where(function (Builder $query) use ($search): void {
                $query->where('file_name', 'like', "%{$search}%")
                    ->orWhere('alt_text', 'like', "%{$search}%")
                    ->orWhere('file_type', 'like', "%{$search}%");
            });
        });
    }

    public function url(): string
    {
        return asset('storage/'.$this->file_path);
    }

    public function sizeForHumans(): string
    {
        if ($this->file_size >= 1048576) {
            return number_format($this->file_size / 1048576, 2).' MB';
        }

        return number_format($this->file_size / 1024, 1).' KB';
    }
}
