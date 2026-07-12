<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CkeditorUploadController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\EventController as FrontendEventController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\SustainabilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutController::class, 'index'])->name('about');
Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [FrontendProductController::class, 'show'])->name('products.show');
Route::get('/news', [FrontendNewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [FrontendNewsController::class, 'show'])->name('news.show');
Route::get('/events', [FrontendEventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [FrontendEventController::class, 'show'])->name('events.show');
Route::get('/gallery', [FrontendGalleryController::class, 'index'])->name('gallery.index');
Route::get('/sustainability', [SustainabilityController::class, 'index'])->name('sustainability');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::redirect('/login', '/admin/login')->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');
Route::redirect('/dashboard', '/admin')->middleware(['auth', 'admin'])->name('dashboard');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::patch('/products/{product}/status', [ProductController::class, 'updateStatus'])->name('products.status');
        Route::delete('/product-images/{productImage}', [ProductController::class, 'destroyImage'])->name('product-images.destroy');
        Route::resource('product-categories', ProductCategoryController::class)
            ->parameters(['product-categories' => 'productCategory'])
            ->except(['show']);
        Route::patch('/product-categories/{productCategory}/status', [ProductCategoryController::class, 'updateStatus'])->name('product-categories.status');
        Route::resource('news', NewsController::class);
        Route::patch('/news/{news}/status', [NewsController::class, 'updateStatus'])->name('news.status');
        Route::resource('events', EventController::class);
        Route::patch('/events/{event}/status', [EventController::class, 'updateStatus'])->name('events.status');
        Route::resource('gallery-categories', GalleryCategoryController::class)
            ->parameters(['gallery-categories' => 'galleryCategory'])
            ->except(['show']);
        Route::patch('/gallery-categories/{galleryCategory}/status', [GalleryCategoryController::class, 'updateStatus'])->name('gallery-categories.status');
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::patch('/galleries/{gallery}/status', [GalleryController::class, 'updateStatus'])->name('galleries.status');
        Route::resource('media', MediaController::class)
            ->parameters(['media' => 'media'])
            ->only(['index', 'store', 'destroy']);
        Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('/contact-messages/{contactMessage}/read', [ContactMessageController::class, 'markRead'])->name('contact-messages.read');
        Route::patch('/contact-messages/{contactMessage}/unread', [ContactMessageController::class, 'markUnread'])->name('contact-messages.unread');
        Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::post('/ckeditor/upload', [CkeditorUploadController::class, 'store'])->name('ckeditor.upload');
        Route::resource('seo-meta', SeoMetaController::class)
            ->parameters(['seo-meta' => 'seoMeta'])
            ->except(['show']);
        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::post('/logout', function (Request $request) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('home');
        })->name('logout');
    });
