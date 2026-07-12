<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'logo_media_id' => ['nullable', 'exists:media,id'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999999'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Please enter the company name.',
            'logo.image' => 'The client logo must be a valid image.',
            'logo.mimes' => 'The client logo must be JPG, JPEG, PNG, or WebP.',
            'logo.max' => 'The client logo must not be larger than 4 MB.',
            'website_url.url' => 'Please enter a valid website URL.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
