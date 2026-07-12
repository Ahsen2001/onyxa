<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\News;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));
        $type = $request->string('type', 'all')->toString();
        
        if (!in_array($type, ['all', 'products', 'news', 'events'], true)) {
            $type = 'all';
        }

        $productsCount = 0;
        $newsCount = 0;
        $eventsCount = 0;
        $results = null;

        if ($query !== '') {
            $searchTerm = '%' . $query . '%';

            // 1. Prepare individual queries (selecting only necessary fields for optimization)
            $productsQuery = Product::query()
                ->selectRaw("id, name as title, slug, 'product' as type, short_description as description, main_image as image, created_at as date")
                ->published()
                ->where(function ($q) use ($searchTerm): void {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('short_description', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
                });

            $newsQuery = News::query()
                ->selectRaw("id, title, slug, 'news' as type, short_description as description, featured_image as image, published_at as date")
                ->published()
                ->where(function ($q) use ($searchTerm): void {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('short_description', 'like', $searchTerm)
                      ->orWhere('content', 'like', $searchTerm);
                });

            $eventsQuery = Event::query()
                ->selectRaw("id, title, slug, 'event' as type, description, featured_image as image, event_date as date")
                ->where('status', '!=', 'cancelled')
                ->where(function ($q) use ($searchTerm): void {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm)
                      ->orWhere('location', 'like', $searchTerm);
                });

            // 2. Fetch counts for each tab using optimized count queries
            $productsCount = $productsQuery->count();
            $newsCount = $newsQuery->count();
            $eventsCount = $eventsQuery->count();

            // 3. Execute query based on the selected type filter
            if ($type === 'products') {
                $results = Product::query()
                    ->selectRaw("id, name as title, slug, 'product' as type, short_description as description, main_image as image, created_at as date")
                    ->published()
                    ->where(function ($q) use ($searchTerm): void {
                        $q->where('name', 'like', $searchTerm)
                          ->orWhere('short_description', 'like', $searchTerm)
                          ->orWhere('description', 'like', $searchTerm);
                    })
                    ->latest()
                    ->paginate(9)
                    ->withQueryString();
            } elseif ($type === 'news') {
                $results = News::query()
                    ->selectRaw("id, title, slug, 'news' as type, short_description as description, featured_image as image, published_at as date")
                    ->published()
                    ->where(function ($q) use ($searchTerm): void {
                        $q->where('title', 'like', $searchTerm)
                          ->orWhere('short_description', 'like', $searchTerm)
                          ->orWhere('content', 'like', $searchTerm);
                    })
                    ->latest('published_at')
                    ->paginate(9)
                    ->withQueryString();
            } elseif ($type === 'events') {
                $results = Event::query()
                    ->selectRaw("id, title, slug, 'event' as type, description, featured_image as image, event_date as date")
                    ->where('status', '!=', 'cancelled')
                    ->where(function ($q) use ($searchTerm): void {
                        $q->where('title', 'like', $searchTerm)
                          ->orWhere('description', 'like', $searchTerm)
                          ->orWhere('location', 'like', $searchTerm);
                    })
                    ->latest('event_date')
                    ->paginate(9)
                    ->withQueryString();
            } else {
                // Combine using Union for the "All" tab
                $unionQuery = $productsQuery->unionAll($newsQuery)->unionAll($eventsQuery);
                
                // Wrap in a subquery for cross-database ordering compatibility
                $results = DB::table(DB::raw("({$unionQuery->toSql()}) as union_search"))
                    ->mergeBindings($unionQuery->getQuery())
                    ->orderBy('date', 'desc')
                    ->paginate(9)
                    ->withQueryString();
            }
        } else {
            // Empty result paginator
            $results = new LengthAwarePaginator([], 0, 9, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }

        $totalCount = $productsCount + $newsCount + $eventsCount;

        return view('frontend.search', compact(
            'results',
            'query',
            'type',
            'productsCount',
            'newsCount',
            'eventsCount',
            'totalCount'
        ));
    }
}
