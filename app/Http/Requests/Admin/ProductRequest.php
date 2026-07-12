<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i', Rule::unique('products', 'name')->ignore($product?->id)],
            'short_description' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'description' => ['nullable', 'string', 'max:10000'],
            'material' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'size' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'main_image_media_id' => ['nullable', 'exists:media,id'],
            'additional_images' => ['nullable', 'array', 'max:10'],
            'additional_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'additional_media_ids' => ['nullable', 'array', 'max:10'],
            'additional_media_ids.*' => ['exists:media,id'],
            'tags' => ['nullable', 'string', 'max:1000', 'not_regex:/<script\b/i'],
            'specification_keys' => ['nullable', 'array', 'max:30'],
            'specification_keys.*' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'specification_values' => ['nullable', 'array', 'max:30'],
            'specification_values.*' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'related_product_ids' => ['nullable', 'array', 'max:12'],
            'related_product_ids.*' => ['integer', 'exists:products,id'],
            'availability' => ['required', Rule::in(['available', 'out_of_stock', 'made_to_order'])],
            'status' => ['required', Rule::in(['draft', 'published', 'inactive'])],
            'is_featured' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'meta_description' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'meta_keywords' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'og_title' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'og_description' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'og_image_media_id' => ['nullable', 'exists:media,id'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots' => ['nullable', Rule::in(['index, follow', 'index, nofollow', 'noindex, follow', 'noindex, nofollow'])],
        ];
    }

    public function messages(): array
    {
        return [
            'product_category_id.required' => 'Please choose a product category.',
            'product_category_id.exists' => 'The selected product category is invalid.',
            'name.required' => 'Please enter the product name.',
            'name.unique' => 'A product with this name already exists.',
            'main_image.image' => 'The main product image must be a valid image.',
            'main_image.max' => 'The main product image must not be larger than 4 MB.',
            'additional_images.max' => 'You can upload up to 10 additional images at once.',
            'additional_images.*.mimes' => 'Additional product images must be JPG, JPEG, PNG, or WebP.',
            'og_image.image' => 'The OG image must be a valid image.',
            'og_image.max' => 'The OG image must not be larger than 4 MB.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
