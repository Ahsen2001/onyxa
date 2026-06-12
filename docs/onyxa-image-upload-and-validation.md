# ONYXA Image Upload and Validation Setup

## Storage Commands

```bash
php artisan storage:link
php artisan migrate
php artisan db:seed
```

Uploaded files are stored on the public disk under `storage/app/public` and served with URLs like:

```blade
{{ asset('storage/'.$product->main_image) }}
```

## Upload Locations

- Product main and additional images: `storage/app/public/products`
- News featured images: `storage/app/public/news`
- Event images: `storage/app/public/events`
- Gallery images: `storage/app/public/gallery`
- Logo and favicon: `storage/app/public/settings`
- Editable page section images: `storage/app/public/pages`

## Controller Upload Examples

```php
if ($request->hasFile('main_image')) {
    Storage::disk('public')->delete($product->main_image);
    $data['main_image'] = $request->file('main_image')->store('products', 'public');
}
```

```php
if ($request->hasFile('featured_image')) {
    $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
}
```

```php
$data['image'] = $request->file('image')->store('gallery', 'public');
```

```php
foreach (['logo', 'favicon'] as $imageKey) {
    if ($request->hasFile($imageKey)) {
        Storage::disk('public')->delete(Setting::valueFor($imageKey));
        $data[$imageKey] = $request->file($imageKey)->store('settings', 'public');
    }
}
```

## File Deletion Examples

```php
Storage::disk('public')->delete($product->main_image);
```

```php
foreach ($product->images as $image) {
    Storage::disk('public')->delete($image->image);
}
```

```php
Storage::disk('public')->delete($news->featured_image);
$news->delete();
```

The admin controllers delete old files when replacing images and delete stored files when product, category, news, event, or gallery records are deleted.

## Blade Image Display Examples

```blade
@if ($product->main_image)
    <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}">
@endif
```

```blade
@if ($news->featured_image)
    <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title }}">
@endif
```

```blade
@php($logo = setting('logo'))
<img src="{{ $logo ? asset('storage/'.$logo) : asset('logo.png') }}" alt="ONYXA logo">
```

## FormRequest Validation Examples

```php
'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
'additional_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
```

```php
'title' => ['required', 'string', 'max:255', 'not_regex:/<script\b/i', Rule::unique('news', 'title')->ignore($news?->id)],
'published_at' => ['nullable', 'date'],
```

```php
'event_date' => ['required', 'date'],
'event_time' => ['nullable', 'date_format:H:i'],
```

```php
'email' => ['required', 'email:rfc', 'max:255'],
'phone' => ['nullable', 'regex:/^[0-9+\-\s().]{7,30}$/'],
```

## Blade Error Display Example

```blade
@error('image')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
@enderror
```

The project also has reusable alert and input components:

```blade
<x-ui.alert type="error">{{ $errors->first() }}</x-ui.alert>
<x-ui.form-input label="Name" name="name" :value="$product->name" required />
```
