<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i'],
            'email' => ['required', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($this->user()?->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', Password::min(12)->mixedCase()->numbers()->symbols()->uncompromised(), 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.unique' => 'This email address is already used by another user.',
            'current_password.required_with' => 'Please enter your current password before setting a new one.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.min' => 'The new password must be at least 12 characters.',
            'password.confirmed' => 'The new password confirmation does not match.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
