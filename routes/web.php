<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\EventFrontendController;
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
Route::view('/gallery', 'frontend.page', ['title' => 'Gallery'])->name('gallery.index');
Route::view('/sustainability', 'frontend.page', ['title' => 'Sustainability'])->name('sustainability');
Route::view('/contact', 'frontend.page', ['title' => 'Contact Us'])->name('contact');

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
        Route::view('/gallery-categories', 'admin.placeholder', ['title' => 'Manage Gallery Categories'])->name('gallery-categories.index');
        Route::view('/galleries', 'admin.placeholder', ['title' => 'Manage Gallery'])->name('galleries.index');
        Route::view('/contact-messages', 'admin.placeholder', ['title' => 'Manage Contact Messages'])->name('contact-messages.index');
        Route::view('/pages', 'admin.placeholder', ['title' => 'Manage Website Pages'])->name('pages.index');
        Route::view('/settings', 'admin.placeholder', ['title' => 'Manage Settings'])->name('settings.index');
        Route::view('/profile', 'admin.placeholder', ['title' => 'Manage Profile'])->name('profile');

        Route::post('/logout', function (Request $request) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('home');
        })->name('logout');
    });
