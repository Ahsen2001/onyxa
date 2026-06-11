<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventFrontendController;
use App\Http\Controllers\GalleryFrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsFrontendController;
use App\Http\Controllers\ProductFrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/products', [ProductFrontendController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductFrontendController::class, 'show'])->name('products.show');
Route::get('/news', [NewsFrontendController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsFrontendController::class, 'show'])->name('news.show');
Route::get('/events', [EventFrontendController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventFrontendController::class, 'show'])->name('events.show');
Route::get('/gallery', [GalleryFrontendController::class, 'index'])->name('gallery.index');
Route::get('/sustainability', [HomeController::class, 'sustainability'])->name('sustainability');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::delete('/product-images/{productImage}', [ProductController::class, 'destroyImage'])->name('product-images.destroy');
        Route::resource('product-categories', ProductCategoryController::class)
            ->parameters(['product-categories' => 'productCategory'])
            ->except(['show']);
        Route::resource('news', NewsController::class);
        Route::resource('events', EventController::class);
        Route::resource('gallery-categories', GalleryCategoryController::class)
            ->parameters(['gallery-categories' => 'galleryCategory'])
            ->except(['show']);
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('/contact-messages/{contactMessage}/read', [ContactMessageController::class, 'markRead'])->name('contact-messages.read');
        Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::view('/profile', 'admin.placeholder', ['title' => 'Manage Profile'])->name('profile');

        Route::post('/logout', function (Request $request) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('home');
        })->name('logout');
    });
