<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'company_name' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'position' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'message' => ['required', 'string', 'max:3000', 'not_regex:/<script\b/i'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_media_id' => ['nullable', 'exists:media,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Please enter the customer name.',
            'message.required' => 'Please enter the testimonial message.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating must not be more than 5 stars.',
            'image.image' => 'The testimonial image must be a valid image.',
            'image.mimes' => 'The testimonial image must be JPG, JPEG, PNG, or WebP.',
            'image.max' => 'The testimonial image must not be larger than 4 MB.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
