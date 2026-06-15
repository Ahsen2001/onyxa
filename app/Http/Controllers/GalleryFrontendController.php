<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryFrontendController extends Controller
{
    public function index(Request $request): View
    {
        $categories = GalleryCategory::active()->ordered()->get();

        $images = Gallery::query()
            ->with('category')
            ->active()
            ->when($request->filled('category'), function ($query) use ($request): void {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', '=', (string) $request->string('category'), 'and'));
            })
            ->latest('updated_at')
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.gallery.index', compact('categories', 'images'));
    }
}
