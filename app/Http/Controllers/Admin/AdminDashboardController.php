<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Product;
use App\Services\GoogleAnalyticsService;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(GoogleAnalyticsService $analytics): View
    {
        $analyticsData = $analytics->dashboard(30);

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
                ->orderBy('event_date', 'asc')
                ->take(5)
                ->get(),
            'recentMessages' => ContactMessage::query()
                ->latest()
                ->take(5)
                ->get(),
            'analytics' => $analyticsData,
            'contactAnalytics' => [
                'total' => ContactMessage::query()->where('created_at', '>=', now()->subDays(29)->startOfDay())->count('*'),
                'new' => ContactMessage::query()->new()->count('*'),
                'replied' => ContactMessage::query()->replied()->count('*'),
                'trend' => $this->contactTrend(),
            ],
        ]);
    }

    private function contactTrend(): array
    {
        $start = now()->subDays(29)->startOfDay();
        $rows = ContactMessage::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        return collect(range(0, 29))
            ->map(function (int $offset) use ($start, $rows): array {
                $date = $start->copy()->addDays($offset);

                return [
                    'label' => $date->format('M d'),
                    'total' => (int) ($rows[$date->toDateString()] ?? 0),
                ];
            })
            ->all();
    }
}
