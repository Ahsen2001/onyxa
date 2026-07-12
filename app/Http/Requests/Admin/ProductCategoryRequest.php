<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        $category = $this->route('productCategory');

        return [
            'name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i', Rule::unique('product_categories', 'name')->ignore($category?->id)],
            'description' => ['nullable', 'string', 'max:3000', 'not_regex:/<script\b/i'],
            'product_names' => ['nullable', 'string', 'max:5000', 'not_regex:/<script\b/i'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the category name.',
            'name.unique' => 'A product category with this name already exists.',
            'image.image' => 'The category image must be a valid image file.',
            'image.mimes' => 'Category images must be JPG, JPEG, PNG, or WebP.',
            'image.max' => 'Category images must not be larger than 2 MB.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
