<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Product;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'products' => Product::query()->count('*'),
                'news' => News::query()->count('*'),
                'events' => Event::query()->count('*'),
                'galleryImages' => Gallery::query()->count('*'),
                'messages' => ContactMessage::query()->count('*'),
                'unreadMessages' => ContactMessage::query()->unread()->count('*'),
            ],
            'latestNews' => News::query()
                ->latest('created_at')
                ->take(5)
                ->get(),
            'upcomingEvents' => Event::query()
                ->upcoming()
                ->orderBy('event_date')
                ->take(5)
                ->get(),
            'recentMessages' => ContactMessage::query()
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
