<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\View\View;

class TestimonialFrontendController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::query()
            ->active()
            ->latest()
            ->paginate(12);

        return view('frontend.testimonials.index', compact('testimonials'));
    }
}
