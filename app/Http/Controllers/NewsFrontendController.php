<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsFrontendController extends Controller
{
    public function index(): View
    {
        $news = News::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

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
