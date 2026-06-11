<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'regex:/^[0-9+\-\s().]{7,30}$/'],
            'subject' => ['nullable', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'message' => ['required', 'string', 'min:10', 'max:5000', 'not_regex:/<script\b/i'],
            'website' => ['nullable', 'prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.regex' => 'Please enter a valid phone number.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Your message should be at least 10 characters.',
            'website.prohibited' => 'Your message could not be submitted.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
