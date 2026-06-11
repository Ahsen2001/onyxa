<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'tagline' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:ico,png,jpg,jpeg,webp', 'max:1024'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'regex:/^[0-9+\-\s().]{7,30}$/'],
            'whatsapp' => ['nullable', 'regex:/^[0-9+\-\s().]{7,30}$/'],
            'address' => ['nullable', 'string', 'max:3000', 'not_regex:/<script\b/i'],
            'business_hours' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'google_map_embed' => ['nullable', 'string', 'max:5000'],
            'footer_text' => ['nullable', 'string', 'max:3000', 'not_regex:/<script\b/i'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Please enter a valid company email address.',
            'phone.regex' => 'Please enter a valid phone number.',
            'whatsapp.regex' => 'Please enter a valid WhatsApp number.',
            'logo.max' => 'The logo must not be larger than 2 MB.',
            'favicon.max' => 'The favicon must not be larger than 1 MB.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
