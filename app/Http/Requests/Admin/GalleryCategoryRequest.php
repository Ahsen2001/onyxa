<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        $category = $this->route('galleryCategory');

        return [
            'name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i', Rule::unique('gallery_categories', 'name')->ignore($category?->id)],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the gallery category name.',
            'name.unique' => 'A gallery category with this name already exists.',
            '*.not_regex' => 'Script tags are not allowed.',
        ];
    }
}
