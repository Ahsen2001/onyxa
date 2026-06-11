# ONYXA Admin Validation Rules

## FormRequest Classes

- Product category form: `App\Http\Requests\Admin\ProductCategoryRequest`
- Product form: `App\Http\Requests\Admin\ProductRequest`
- News form: `App\Http\Requests\Admin\NewsRequest`
- Event form: `App\Http\Requests\Admin\EventRequest`
- Gallery category form: `App\Http\Requests\Admin\GalleryCategoryRequest`
- Gallery image form: `App\Http\Requests\Admin\GalleryRequest`
- Contact form: `App\Http\Requests\ContactRequest`
- Settings form: `App\Http\Requests\Admin\SettingRequest`
- Profile and password form: `App\Http\Requests\Admin\ProfileUpdateRequest`

## Controller Usage

```php
public function store(ProductRequest $request): RedirectResponse
{
    $data = $request->validated();
    $data['slug'] = $this->uniqueSlug($data['name']);
}
```

```php
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $data = $request->validated();
}
```

## Shared Validation Patterns

```php
'name' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i'],
'email' => ['required', 'email:rfc', 'max:255'],
'phone' => ['nullable', 'regex:/^[0-9+\-\s().]{7,30}$/'],
'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
```

```php
Rule::unique('products', 'name')->ignore($product?->id)
Rule::unique('news', 'title')->ignore($news?->id)
Rule::unique('events', 'title')->ignore($event?->id)
```

## Event Rules

```php
'event_date' => ['required', 'date'],
'event_time' => ['nullable', 'date_format:H:i'],
'status' => ['required', Rule::in(['upcoming', 'completed', 'cancelled'])],
```

## Password Rules

```php
'current_password' => ['nullable', 'required_with:password', 'current_password'],
'password' => ['nullable', 'string', 'min:8', 'confirmed'],
```

## Blade Error Display

```blade
@if ($errors->any())
    <x-ui.alert type="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.alert>
@endif
```

```blade
@error('email')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
@enderror
```
