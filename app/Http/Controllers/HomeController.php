<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('frontend.home', [
            'featuredProducts' => Product::query()
                ->with('category')
                ->published()
                ->featured()
                ->latest()
                ->take(6)
                ->get(),
            'latestNews' => News::query()
                ->latestPublished()
                ->take(3)
                ->get(),
            'upcomingEvents' => Event::query()
                ->upcoming()
                ->orderBy('event_date')
                ->take(3)
                ->get(),
            'galleryImages' => Gallery::query()
                ->active()
                ->ordered()
                ->take(6)
                ->get(),
        ]);
    }

    public function about(): View
    {
        return view('frontend.about');
    }

    public function sustainability(): View
    {
        return view('frontend.sustainability.index');
    }
}
