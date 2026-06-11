<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventFrontendController extends Controller
{
    public function index(): View
    {
        $upcomingEvents = Event::query()
            ->upcoming()
            ->orderBy('event_date')
            ->paginate(6, ['*'], 'upcoming_page');

        $completedEvents = Event::query()
            ->completed()
            ->latest('event_date')
            ->paginate(6, ['*'], 'completed_page');

        return view('frontend.events.index', compact('upcomingEvents', 'completedEvents'));
    }

    public function show(Event $event): View
    {
        abort_if($event->status === 'cancelled', 404);

        $relatedEvents = Event::query()
            ->whereKeyNot($event->id)
            ->where('status', $event->status)
            ->orderBy('event_date')
            ->take(3)
            ->get();

        return view('frontend.events.show', compact('event', 'relatedEvents'));
    }
}
