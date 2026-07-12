<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        $event = $this->route('event');

        return [
            'title' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i', Rule::unique('events', 'title')->ignore($event?->id)],
            'description' => ['required', 'string', 'max:15000'],
            'event_date' => ['required', 'date'],
            'event_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'featured_image_media_id' => ['nullable', 'exists:media,id'],
            'status' => ['required', Rule::in(['upcoming', 'completed', 'cancelled'])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter the event title.',
            'title.unique' => 'An event with this title already exists.',
            'description.required' => 'Please enter the event description.',
            'event_date.required' => 'Please choose the event date.',
            'event_date.date' => 'Please choose a valid event date.',
            'event_time.date_format' => 'Please enter the time in HH:MM format.',
            'featured_image.max' => 'Event images must not be larger than 4 MB.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
