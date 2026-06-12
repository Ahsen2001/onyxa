<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventFrontendController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->string('status');

        if (in_array($status, ['upcoming', 'completed'], true)) {
            $events = Event::query()
                ->where('status', $status)
                ->when($status === 'upcoming', fn ($query) => $query->whereDate('event_date', '>=', now()->toDateString())->orderBy('event_date'))
                ->when($status === 'completed', fn ($query) => $query->latest('event_date'))
                ->paginate(9)
                ->withQueryString();

            return view('frontend.events.index', compact('events', 'status'));
        }

        $upcomingEvents = Event::query()
            ->upcoming()
            ->orderBy('event_date')
            ->paginate(6, ['*'], 'upcoming_page')
            ->withQueryString();

        $completedEvents = Event::query()
            ->completed()
            ->latest('event_date')
            ->paginate(6, ['*'], 'completed_page')
            ->withQueryString();

        return view('frontend.events.index', compact('upcomingEvents', 'completedEvents', 'status'));
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
