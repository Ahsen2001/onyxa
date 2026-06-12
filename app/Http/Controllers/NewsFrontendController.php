<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsFrontendController extends Controller
{
    public function index(Request $request): View
    {
        $news = News::query()
            ->published()
            ->when($request->filled('search'), function ($query) use ($request): void {
                $query->where('title', 'like', '%'.(string) $request->string('search').'%');
            });

        match ((string) $request->string('sort')) {
            'oldest' => $news->oldest('published_at'),
            default => $news->latest('published_at'),
        };

        $news = $news->paginate(9)->withQueryString();

        return view('frontend.news.index', compact('news'));
    }

    public function show(News $news): View
    {
        abort_unless($news->status === 'published' && $news->published_at && $news->published_at->lte(now()), 404);

        $relatedNews = News::query()
            ->published()
            ->whereKeyNot($news->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('frontend.news.show', compact('news', 'relatedNews'));
    }
}
