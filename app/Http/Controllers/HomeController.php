<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::query()
            ->with('category')
            ->published()
            ->featured()
            ->latest('updated_at')
            ->take(6)
            ->get();

        if ($featuredProducts->count() < 6) {
            $fillProducts = Product::query()
                ->with('category')
                ->published()
                ->whereNotIn('id', $featuredProducts->pluck('id'))
                ->latest('updated_at')
                ->take(6 - $featuredProducts->count())
                ->get();

            $featuredProducts = $featuredProducts->concat($fillProducts);
        }

        return view('frontend.home', [
            'featuredProducts' => $featuredProducts,
            'latestNews' => News::query()
                ->latestPublished()
                ->take(3)
                ->get(),
            'upcomingEvents' => Event::query()
                ->upcoming()
                ->orderBy('event_date', 'asc')
                ->take(3)
                ->get(),
            'galleryImages' => Gallery::query()
                ->active()
                ->latest('updated_at')
                ->latest('created_at')
                ->take(6)
                ->get(),
            'clients' => Client::query()
                ->active()
                ->ordered()
                ->take(12)
                ->get(),
            'testimonials' => Testimonial::query()
                ->active()
                ->latest()
                ->take(8)
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
