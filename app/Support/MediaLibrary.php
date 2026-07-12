<?php

namespace App\Support;

use App\Models\Event;
use App\Models\Client;
use App\Models\Media;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Testimonial;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaLibrary
{
    public static function store(UploadedFile $file, ?int $uploadedBy = null, ?string $altText = null, string $directory = 'media'): Media
    {
        $path = $file->store($directory, 'public');

        return Media::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getMimeType() ?: 'application/octet-stream',
            'file_size' => $file->getSize() ?: 0,
            'alt_text' => $altText,
            'uploaded_by' => $uploadedBy,
        ]);
    }

    public static function imagePathFromRequest(mixed $mediaId): ?string
    {
        if (! $mediaId) {
            return null;
        }

        return Media::images()->whereKey($mediaId)->value('file_path');
    }

    public static function isUsed(Media $media): bool
    {
        $path = $media->file_path;

        return Product::query()->where('main_image', $path)->orWhere('og_image', $path)->exists()
            || ProductImage::query()->where('image', $path)->exists()
            || News::query()->where('featured_image', $path)->exists()
            || Event::query()->where('featured_image', $path)->exists()
            || Page::query()->where('image', $path)->exists()
            || Client::query()->where('logo', $path)->exists()
            || Testimonial::query()->where('image', $path)->exists();
    }

    public static function deleteIfUntracked(?string $path): void
    {
        if (! $path || Media::query()->where('file_path', $path)->exists()) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
