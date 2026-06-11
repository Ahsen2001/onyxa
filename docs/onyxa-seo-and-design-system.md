# ONYXA SEO and Design System

## SEO Routes

```php
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');
```

## Blade Meta Sections

```blade
@section('title', $product->meta_title ?: $product->name.' - ONYXA Private Limited')
@section('meta_description', $product->meta_description ?: $product->short_description)
@section('canonical', route('products.show', $product))
@section('og_type', 'product')
@section('og_image', asset('storage/'.$product->main_image))
```

The public layout reads these sections and outputs standard description, canonical, Open Graph, and Twitter card tags.

## Slug Generation

Admin create/update controllers generate slugs from product, news, event, and category names with Laravel's `Str::slug()` helper.

## Tailwind Brand Tokens

- `brand-brown`: `#8B5E3C`
- `brand-green`: `#2E7D32`
- `brand-cream`: `#FFF8EC`
- `brand-gold`: `#D9A441`
- `brand-dark`: `#2B2B2B`

## Component Examples

```blade
<x-ui.button href="{{ route('products.index') }}">Explore Products</x-ui.button>
<x-ui.button variant="secondary" href="{{ route('contact') }}">Contact Us</x-ui.button>

<x-ui.section-title
    eyebrow="Handmade"
    title="Coconut shell craft with purpose"
    description="Natural materials, artisan finishes, and sustainable production."
/>

<x-ui.product-card :product="$product" :whatsapp-number="setting('whatsapp')" />
<x-ui.news-card :post="$post" />
<x-ui.event-card :event="$event" />
<x-ui.gallery-card :gallery="$gallery" />

<x-ui.admin-card title="Total Products" :value="$totalProducts" />
<x-ui.status-badge status="published" />
<x-ui.form-input label="Title" name="title" :value="$page->title" required />

<x-ui.alert>Saved successfully.</x-ui.alert>
<x-ui.alert type="error">Please check the form.</x-ui.alert>
```
