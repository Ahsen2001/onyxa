# ONYXA Laravel Migrations, Models, and Admin Role System

This project already contains the generated files described below.

## Artisan Commands

Run these commands from the project root if you need to recreate the files manually in another Laravel project.

```bash
php artisan make:model ProductCategory -m
php artisan make:model Product -m
php artisan make:model ProductImage -m
php artisan make:model News -m
php artisan make:model Event -m
php artisan make:model GalleryCategory -m
php artisan make:model Gallery -m
php artisan make:model ContactMessage -m
php artisan make:model Page -m
php artisan make:model Setting -m
php artisan make:middleware AdminMiddleware
php artisan make:seeder AdminUserSeeder
php artisan make:seeder SettingSeeder
```

## Migration Files

| Table | Artisan command | Migration file |
| --- | --- | --- |
| `users` | Laravel default users migration, updated with role fields | `database/migrations/0001_01_01_000000_create_users_table.php` |
| `product_categories` | `php artisan make:model ProductCategory -m` | `database/migrations/2026_06_11_000000_create_product_categories_table.php` |
| `products` | `php artisan make:model Product -m` | `database/migrations/2026_06_11_000001_create_products_table.php` |
| `product_images` | `php artisan make:model ProductImage -m` | `database/migrations/2026_06_11_000002_create_product_images_table.php` |
| `news` | `php artisan make:model News -m` | `database/migrations/2026_06_11_000003_create_news_table.php` |
| `events` | `php artisan make:model Event -m` | `database/migrations/2026_06_11_000004_create_events_table.php` |
| `gallery_categories` | `php artisan make:model GalleryCategory -m` | `database/migrations/2026_06_11_000005_create_gallery_categories_table.php` |
| `galleries` | `php artisan make:model Gallery -m` | `database/migrations/2026_06_11_000006_create_galleries_table.php` |
| `contact_messages` | `php artisan make:model ContactMessage -m` | `database/migrations/2026_06_11_000007_create_contact_messages_table.php` |
| `pages` | `php artisan make:model Page -m` | `database/migrations/2026_06_11_000008_create_pages_table.php` |
| `settings` | `php artisan make:model Setting -m` | `database/migrations/2026_06_11_000009_create_settings_table.php` |

Each migration includes timestamps and the required foreign keys:

- `products.product_category_id` references `product_categories.id`
- `product_images.product_id` references `products.id`
- `news.author_id` references `users.id`
- `events.author_id` references `users.id`
- `galleries.gallery_category_id` references `gallery_categories.id`

## Model Files

The generated Eloquent model files are:

```text
app/Models/ProductCategory.php
app/Models/Product.php
app/Models/ProductImage.php
app/Models/News.php
app/Models/Event.php
app/Models/GalleryCategory.php
app/Models/Gallery.php
app/Models/ContactMessage.php
app/Models/Page.php
app/Models/Setting.php
app/Models/User.php
```

They include fillable fields, relationship methods, casts, and useful scopes such as:

- `active()`
- `published()`
- `upcoming()`
- `featured()`
- `ordered()`
- `unread()`

## Admin Role System

The `users` table has:

```php
$table->enum('role', ['admin', 'user'])->default('user');
```

The middleware file is:

```text
app/Http/Middleware/AdminMiddleware.php
```

It redirects guests and non-admin users to the homepage.

Laravel 12 middleware registration is in:

```text
bootstrap/app.php
```

The alias is:

```php
'admin' => \App\Http\Middleware\AdminMiddleware::class
```

Protected admin routes are in:

```text
routes/web.php
```

The route group uses:

```php
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        // admin dashboard and CRUD pages
    });
```

## Default Admin

The default admin seeder is:

```text
database/seeders/AdminUserSeeder.php
```

Default credentials:

```text
Name: Admin
Email: admin@onyxa.com
Password: admin12345
```

The password is stored with secure Laravel hashing:

```php
Hash::make('admin12345')
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```
