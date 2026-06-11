<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about-us', 'frontend.page', ['title' => 'About Us'])->name('about');
Route::view('/products', 'frontend.page', ['title' => 'Products'])->name('products.index');
Route::view('/news', 'frontend.page', ['title' => 'News'])->name('news.index');
Route::view('/events', 'frontend.page', ['title' => 'Events'])->name('events.index');
Route::view('/gallery', 'frontend.page', ['title' => 'Gallery'])->name('gallery.index');
Route::view('/sustainability', 'frontend.page', ['title' => 'Sustainability'])->name('sustainability');
Route::view('/contact', 'frontend.page', ['title' => 'Contact Us'])->name('contact');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::view('/products', 'admin.placeholder', ['title' => 'Manage Products'])->name('products.index');
        Route::view('/product-categories', 'admin.placeholder', ['title' => 'Manage Product Categories'])->name('product-categories.index');
        Route::view('/news', 'admin.placeholder', ['title' => 'Manage News'])->name('news.index');
        Route::view('/events', 'admin.placeholder', ['title' => 'Manage Events'])->name('events.index');
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
