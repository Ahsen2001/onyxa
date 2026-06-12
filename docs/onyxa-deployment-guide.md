# ONYXA Private Limited Laravel Deployment Guide

Target hosting: cPanel hosting or shared hosting that supports Laravel, PHP 8.2+, Composer, MySQL, and SSH or Terminal access.

## 1. Prepare the Project for Production

Before uploading, make sure the local project is working.

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build
php artisan route:list
```

Recommended local checks:

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

Do not upload local cache files from `bootstrap/cache` if they were created for a different environment.

## 2. Production `.env` Settings

Create or edit `.env` on the server.

```env
APP_NAME="ONYXA Private Limited"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_APP_KEY
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpaneluser_onyxa
DB_USERNAME=cpaneluser_onyxauser
DB_PASSWORD=your_secure_password

SESSION_DRIVER=file
FILESYSTEM_DISK=public
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=info@your-domain.com
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

Important:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL` must be the real domain.
- Keep `.env` outside public access.
- Never commit production `.env` to Git.

If `APP_KEY` is empty, run:

```bash
php artisan key:generate --force
```

## 3. Create MySQL Database in cPanel

In cPanel:

1. Open **MySQL Databases**.
2. Create a database, for example `cpaneluser_onyxa`.
3. Create a database user, for example `cpaneluser_onyxauser`.
4. Set a strong password.
5. Add the user to the database.
6. Grant **All Privileges**.

Update `.env` with the exact cPanel database name, username, and password.

Test database connection:

```bash
php artisan migrate:status
```

## 4. Upload Laravel Files

Recommended shared hosting structure:

```text
home/cpaneluser/
├── onyxa/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── artisan
└── public_html/
```

Upload the Laravel project to a folder like:

```text
/home/cpaneluser/onyxa
```

Then point the domain document root to:

```text
/home/cpaneluser/onyxa/public
```

This is the safest setup because only the Laravel `public` folder is exposed to visitors.

## 5. Set the Public Folder Correctly

Best option:

- In cPanel domain settings, set document root to `/home/cpaneluser/onyxa/public`.

If your hosting does not allow changing document root:

1. Move the contents of Laravel `public` into `public_html`.
2. Edit `public_html/index.php`.

Change paths from:

```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

To:

```php
require __DIR__.'/../onyxa/vendor/autoload.php';
$app = require_once __DIR__.'/../onyxa/bootstrap/app.php';
```

Also copy these public assets into `public_html`:

- `build/`
- `storage/` symlink or copied storage files
- `logo.png`
- `.htaccess`
- `favicon` files if any

## 6. Run Composer Install

From the Laravel project folder on the server:

```bash
cd /home/cpaneluser/onyxa
composer install --no-dev --optimize-autoloader
```

If Composer is not available in SSH, use cPanel Terminal or ask hosting support to enable Composer.

If memory errors occur:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader
```

## 7. Run Migrations and Seeders

Run database migrations:

```bash
php artisan migrate --force
```

Seed default data:

```bash
php artisan db:seed --force
```

If you only need the default admin and settings seeders:

```bash
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=SettingSeeder --force
```

Default admin account:

```text
Email: admin@onyxa.com
Password: admin12345
```

Change this password immediately after deployment.

## 8. Create Storage Link

ONYXA stores uploads in `storage/app/public`.

Run:

```bash
php artisan storage:link
```

This creates:

```text
public/storage -> storage/app/public
```

If symlinks are disabled on shared hosting, manually copy uploaded files to:

```text
public/storage
```

or ask hosting support to enable symlinks.

Image folders used by the website:

```text
storage/app/public/products
storage/app/public/news
storage/app/public/events
storage/app/public/gallery
storage/app/public/categories
storage/app/public/settings
storage/app/public/pages
```

## 9. Set File Permissions

Recommended permissions:

```bash
find storage -type d -exec chmod 775 {} \;
find storage -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;
```

If the server user needs ownership:

```bash
chown -R cpaneluser:cpaneluser storage bootstrap/cache
```

On many cPanel servers, `755` for directories and `644` for files is enough. Avoid `777` unless hosting support specifically requires it.

## 10. Config Cache Commands

After `.env` is correct:

```bash
php artisan config:clear
php artisan config:cache
```

Use `config:clear` after changing `.env`:

```bash
php artisan config:clear
```

Then reload the website.

## 11. Route Cache and View Cache Commands

For production optimization:

```bash
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache
php artisan cache:clear
```

Full optimization command:

```bash
php artisan optimize
```

Clear all Laravel optimization caches:

```bash
php artisan optimize:clear
```

Run `optimize:clear` when routes, config, or Blade files change.

## 12. Fix Common Hosting Errors

### Missing App Key

Error:

```text
No application encryption key has been specified.
```

Fix:

```bash
php artisan key:generate --force
php artisan config:clear
```

### Database Table Does Not Exist

Error:

```text
Base table or view not found
```

Fix:

```bash
php artisan migrate --force
php artisan db:seed --force
```

### Sessions Table Missing

If using database sessions, run:

```bash
php artisan session:table
php artisan migrate --force
```

For ONYXA shared hosting, the simpler setting is:

```env
SESSION_DRIVER=file
```

Then run:

```bash
php artisan config:clear
```

### 500 Internal Server Error

Check:

- `.env` exists.
- `APP_KEY` exists.
- `APP_DEBUG=false` in production.
- `storage` and `bootstrap/cache` are writable.
- Composer dependencies are installed.
- PHP version is 8.2 or higher.

Useful commands:

```bash
php artisan optimize:clear
php artisan config:cache
tail -n 100 storage/logs/laravel.log
```

### Blank Page or CSS Missing

Make sure assets were built and uploaded:

```bash
npm install
npm run build
```

Upload:

```text
public/build
```

If assets still do not load, check `APP_URL`.

### Images Not Showing

Run:

```bash
php artisan storage:link
```

Check file exists in:

```text
storage/app/public
public/storage
```

Check permissions:

```bash
chmod -R 775 storage
```

### Admin Routes Show 403 or Redirect Home

Confirm the logged-in user has:

```text
role = admin
```

In MySQL/phpMyAdmin:

```sql
SELECT id, name, email, role FROM users;
```

Update if needed:

```sql
UPDATE users SET role = 'admin' WHERE email = 'admin@onyxa.com';
```

### Route Cache Error

If route caching fails, clear it:

```bash
php artisan route:clear
php artisan optimize:clear
```

Then check route definitions:

```bash
php artisan route:list
```

## 13. Admin Login Testing

Open:

```text
https://your-domain.com/admin/login
```

Test:

```text
Email: admin@onyxa.com
Password: admin12345
```

Expected result:

- Admin logs in successfully.
- User is redirected to `/admin`.
- Dashboard shows products, news, events, gallery, and message counts.
- Sidebar links work.

After login, change the password from the admin profile page.

## 14. Contact Form Testing

Open:

```text
https://your-domain.com/contact
```

Submit a test message:

```text
Name: Test Visitor
Email: test@example.com
Phone: +94 000 000 000
Subject: Website test
Message: This is a production contact form test.
```

Expected result:

- Success message appears.
- Record is saved in `contact_messages`.
- Admin dashboard unread message count increases.
- Message appears under admin messages.

Admin route:

```text
https://your-domain.com/admin/contact-messages
```

If the message is not saved:

```bash
php artisan migrate:status
tail -n 100 storage/logs/laravel.log
```

## 15. Image Upload Testing

Test these admin upload areas:

- Product main image
- Product additional images
- Product category image
- News featured image
- Event featured image
- Gallery image
- Settings logo
- Settings favicon
- Editable page section image

Expected result:

- Upload succeeds without validation error.
- File appears in `storage/app/public/...`.
- Image appears in admin table or edit page.
- Image appears on the public website.

If upload fails:

Check upload limits in hosting PHP settings:

```ini
upload_max_filesize = 8M
post_max_size = 16M
memory_limit = 256M
max_execution_time = 120
```

Check Laravel validation limits in FormRequest classes.

Check storage permissions:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Check public storage link:

```bash
php artisan storage:link
```

## Recommended Final Deployment Command Sequence

Run from the Laravel project directory:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If Node is available on the server:

```bash
npm install
npm run build
```

If Node is not available, build locally and upload:

```text
public/build
```

## Post-Deployment Checklist

| Check | Expected Result |
| --- | --- |
| Home page | Loads without error |
| About page | Content displays |
| Products page | Active products display |
| Product details | Slug URL works |
| News page | Published news displays |
| Events page | Upcoming and completed events display |
| Gallery page | Images display |
| Contact page | Form and Google map display |
| Admin login | Admin can log in |
| Dashboard | Counts display correctly |
| Image uploads | Images upload and display |
| Contact messages | Public messages appear in admin |
| Settings | Logo, favicon, contact details update |
| Security | `APP_DEBUG=false` |
| Storage | `/storage/...` images are accessible |
