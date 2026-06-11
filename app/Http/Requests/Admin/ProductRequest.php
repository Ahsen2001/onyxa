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
            'description' => ['nullable', 'string', 'max:10000', 'not_regex:/<script\b/i'],
            'material' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'size' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'additional_images' => ['nullable', 'array', 'max:10'],
            'additional_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'availability' => ['required', Rule::in(['available', 'out_of_stock', 'made_to_order'])],
            'status' => ['required', Rule::in(['draft', 'published', 'inactive'])],
            'is_featured' => ['nullable', 'boolean'],
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
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
