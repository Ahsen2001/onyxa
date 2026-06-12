# ONYXA Search, WhatsApp, Security, and Status Controls

## Public Search and Filter Routes

```php
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
```

## Query Builder Examples

```php
Product::query()
    ->published()
    ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
    ->when($request->filled('availability'), fn ($query) => $query->where('availability', $request->string('availability')))
    ->paginate(9)
    ->withQueryString();
```

```php
News::query()
    ->published()
    ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->string('search').'%'))
    ->latest('published_at')
    ->paginate(9)
    ->withQueryString();
```

## WhatsApp URL Format

```php
whatsapp_url('Hello ONYXA Private Limited, I am interested in '.$product->name.'. Please send me more details.')
```

The helper builds:

```text
https://wa.me/{number}?text={url-encoded-message}
```

It reads the WhatsApp number from the `settings` table using the `whatsapp` key.

## Admin Status Routes

```php
Route::patch('/products/{product}/status', [ProductController::class, 'updateStatus'])->name('products.status');
Route::patch('/product-categories/{productCategory}/status', [ProductCategoryController::class, 'updateStatus'])->name('product-categories.status');
Route::patch('/news/{news}/status', [NewsController::class, 'updateStatus'])->name('news.status');
Route::patch('/events/{event}/status', [EventController::class, 'updateStatus'])->name('events.status');
Route::patch('/gallery-categories/{galleryCategory}/status', [GalleryCategoryController::class, 'updateStatus'])->name('gallery-categories.status');
Route::patch('/galleries/{gallery}/status', [GalleryController::class, 'updateStatus'])->name('galleries.status');
Route::patch('/contact-messages/{contactMessage}/read', [ContactMessageController::class, 'markRead'])->name('contact-messages.read');
Route::patch('/contact-messages/{contactMessage}/unread', [ContactMessageController::class, 'markUnread'])->name('contact-messages.unread');
```

## Badge Component

```blade
<x-ui.status-badge :status="$product->status" />
```

## Security Controls

- Admin routes are protected by `auth` and `admin` middleware.
- Admin users are checked through `User::isAdmin()`.
- Forms use `@csrf`.
- Passwords use Laravel hashing through the `User` model cast and `Hash::make()` in seeders.
- FormRequest classes validate admin and contact form input.
- Upload fields validate image type and size.
- Eloquent and query builder calls use parameter binding.
- Blade output uses escaped `{{ }}` output except the trusted Google map embed setting.
- Models define `$fillable` fields to prevent mass assignment surprises.
- Route model binding is used only behind authorization-sensitive admin middleware for admin records.

## Responsive Design Notes

- Public filters use stacked mobile grids and wider desktop columns.
- Cards use `sm:grid-cols-2` and `lg:grid-cols-3`.
- Admin tables are wrapped in `overflow-x-auto`.
- Admin sidebar uses a mobile toggle and overlay.
- Buttons use full-width or stacked layout on smaller screens where needed.
