# ONYXA Controller Structure

## Namespaces

- Frontend controllers: `App\Http\Controllers\Frontend`
- Admin controllers: `App\Http\Controllers\Admin`
- Auth/profile controllers: `App\Http\Controllers\Admin\AuthController` and `App\Http\Controllers\Admin\ProfileController`

## Artisan Commands

```bash
php artisan make:controller Frontend/HomeController
php artisan make:controller Frontend/AboutController
php artisan make:controller Frontend/ProductController
php artisan make:controller Frontend/NewsController
php artisan make:controller Frontend/EventController
php artisan make:controller Frontend/GalleryController
php artisan make:controller Frontend/ContactController
php artisan make:controller Frontend/SustainabilityController

php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/ProductCategoryController --resource
php artisan make:controller Admin/ProductController --resource
php artisan make:controller Admin/NewsController --resource
php artisan make:controller Admin/EventController --resource
php artisan make:controller Admin/GalleryCategoryController --resource
php artisan make:controller Admin/GalleryController --resource
php artisan make:controller Admin/ContactMessageController
php artisan make:controller Admin/PageController
php artisan make:controller Admin/SettingController
php artisan make:controller Admin/ProfileController
```

## Example Controller Shape

```php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('frontend.about');
    }
}
```

```php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', ['admin' => $request->user()]);
    }
}
```
