<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        $news = $this->route('news');

        return [
            'title' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i', Rule::unique('news', 'title')->ignore($news?->id)],
            'short_description' => ['nullable', 'string', 'max:500', 'not_regex:/<script\b/i'],
            'content' => ['required', 'string', 'max:20000'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'featured_image_media_id' => ['nullable', 'exists:media,id'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter the news title.',
            'title.unique' => 'A news post with this title already exists.',
            'content.required' => 'Please enter the news content.',
            'featured_image.mimes' => 'News images must be JPG, JPEG, PNG, or WebP.',
            'featured_image.max' => 'News images must not be larger than 4 MB.',
            'published_at.date' => 'Please choose a valid publish date.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
