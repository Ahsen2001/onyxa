<?php

namespace App\Http\Requests\Admin;

use App\Models\Event;
use App\Models\News;
use App\Models\Product;
use App\Models\SeoMeta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeoMetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'page_id' => $this->filled('page_id') ? (int) $this->input('page_id') : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'page_type' => ['required', Rule::in(array_keys(SeoMeta::pageTypes()))],
            'page_id' => ['nullable', 'integer', 'min:1'],
            'meta_title' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'meta_description' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'meta_keywords' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'og_title' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'og_description' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots' => ['required', 'string', 'max:100', 'not_regex:/<script\b/i'],
            'schema_json_ld' => ['nullable', 'json'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $pageType = (string) $this->input('page_type');
            $pageId = $this->input('page_id');
            $seoMeta = $this->route('seoMeta');

            if (! in_array($pageType, array_keys(SeoMeta::pageTypes()), true)) {
                return;
            }

            if (in_array($pageType, SeoMeta::detailPageTypes(), true)) {
                if (! $pageId) {
                    $validator->errors()->add('page_id', 'Page ID is required for detail pages.');

                    return;
                }

                if (! $this->targetExists($pageType, (int) $pageId)) {
                    $validator->errors()->add('page_id', 'The selected page ID does not exist for this page type.');

                    return;
                }
            }

            if (in_array($pageType, SeoMeta::staticPageTypes(), true) && $pageId) {
                $validator->errors()->add('page_id', 'Leave Page ID empty for static/listing pages.');

                return;
            }

            $duplicate = SeoMeta::query()
                ->where('page_type', $pageType)
                ->when($pageId, fn ($query) => $query->where('page_id', (int) $pageId), fn ($query) => $query->whereNull('page_id'))
                ->when($seoMeta, fn ($query) => $query->whereKeyNot($seoMeta->id))
                ->exists();

            if ($duplicate) {
                $validator->errors()->add('page_type', 'SEO meta already exists for this page target.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'page_type.required' => 'Please choose a page type.',
            'og_image.image' => 'The OG image must be a valid image.',
            'og_image.mimes' => 'The OG image must be JPG, JPEG, PNG, or WebP.',
            'og_image.max' => 'The OG image must not be larger than 4 MB.',
            'canonical_url.url' => 'Please enter a valid canonical URL.',
            'schema_json_ld.json' => 'Schema JSON-LD must be valid JSON.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }

    private function targetExists(string $pageType, int $pageId): bool
    {
        return match ($pageType) {
            'product_detail' => Product::query()->whereKey($pageId)->exists(),
            'news_detail' => News::query()->whereKey($pageId)->exists(),
            'event_detail' => Event::query()->whereKey($pageId)->exists(),
            default => true,
        };
    }
}
