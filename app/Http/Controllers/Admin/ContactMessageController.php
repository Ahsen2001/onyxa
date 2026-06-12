<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $search = trim($request->string('search')->toString());

        $messages = ContactMessage::query()
            ->when($status === 'unread', fn ($query) => $query->unread())
            ->when($status === 'read', fn ($query) => $query->read())
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($messageQuery) use ($search): void {
                    $messageQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $counts = [
            'all' => ContactMessage::count(),
            'unread' => ContactMessage::unread()->count(),
            'read' => ContactMessage::read()->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'counts', 'status', 'search'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update(['is_read' => true]);

        return back()->with('success', 'Message marked as read.');
    }

    public function markUnread(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update(['is_read' => false]);

        return back()->with('success', 'Message marked as unread.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
