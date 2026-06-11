<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return [
            'gallery_category_id' => ['nullable', 'exists:gallery_categories,id'],
            'title' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'description' => ['nullable', 'string', 'max:3000', 'not_regex:/<script\b/i'],
            'image' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Please upload a gallery image.',
            'image.image' => 'The gallery file must be a valid image.',
            'image.mimes' => 'Gallery images must be JPG, JPEG, PNG, or WebP.',
            'image.max' => 'Gallery images must not be larger than 4 MB.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
