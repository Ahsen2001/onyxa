<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::view('/products', 'admin.placeholder', ['title' => 'Manage Products'])->name('products.index');
        Route::view('/product-categories', 'admin.placeholder', ['title' => 'Manage Product Categories'])->name('product-categories.index');
        Route::view('/news', 'admin.placeholder', ['title' => 'Manage News'])->name('news.index');
        Route::view('/events', 'admin.placeholder', ['title' => 'Manage Events'])->name('events.index');
        Route::view('/gallery-categories', 'admin.placeholder', ['title' => 'Manage Gallery Categories'])->name('gallery-categories.index');
        Route::view('/galleries', 'admin.placeholder', ['title' => 'Manage Gallery'])->name('galleries.index');
        Route::view('/contact-messages', 'admin.placeholder', ['title' => 'Manage Contact Messages'])->name('contact-messages.index');
        Route::view('/pages', 'admin.placeholder', ['title' => 'Manage Website Pages'])->name('pages.index');
        Route::view('/settings', 'admin.placeholder', ['title' => 'Manage Settings'])->name('settings.index');
    });
