<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $search = trim($request->string('search')->toString());

        $messages = ContactMessage::query()
            ->when(in_array($status, ['new', 'reading', 'replied', 'closed'], true), fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($messageQuery) use ($search): void {
                    $messageQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%")
                        ->orWhere('internal_notes', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $counts = [
            'all' => ContactMessage::query()->count('*'),
            'new' => ContactMessage::query()->where('status', 'new')->count('*'),
            'reading' => ContactMessage::query()->where('status', 'reading')->count('*'),
            'replied' => ContactMessage::query()->where('status', 'replied')->count('*'),
            'closed' => ContactMessage::query()->where('status', 'closed')->count('*'),
        ];

        return view('admin.contact-messages.index', compact('messages', 'counts', 'status', 'search'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        if ($contactMessage->status === 'new') {
            $contactMessage->update([
                'status' => 'reading',
                'is_read' => true
            ]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:new,reading,replied,closed',
        ]);

        $status = $request->input('status');
        
        $contactMessage->update([
            'status' => $status,
            'is_read' => ($status !== 'new'),
        ]);

        return back()->with('success', 'Message status updated to ' . ucwords($status) . '.');
    }

    public function updateNotes(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $request->validate([
            'internal_notes' => 'nullable|string|max:5000',
        ]);

        $contactMessage->update([
            'internal_notes' => $request->input('internal_notes'),
        ]);

        return back()->with('success', 'Internal notes updated successfully.');
    }

    public function reply(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $request->validate([
            'reply_subject' => 'required|string|max:255',
            'reply_message' => 'required|string|max:10000',
        ]);

        $subject = $request->input('reply_subject');
        $message = $request->input('reply_message');

        try {
            \Illuminate\Support\Facades\Mail::to($contactMessage->email)
                ->send(new \App\Mail\ContactMessageReply($contactMessage, $subject, $message));

            $contactMessage->update([
                'status' => 'replied',
                'replied_at' => now(),
            ]);

            return back()->with('success', 'Reply email sent successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send contact message reply email: ' . $e->getMessage());
            return back()->withErrors(['reply_error' => 'Failed to send reply email. Please check mail settings and try again.']);
        }
    }

    public function export(Request $request): StreamedResponse
    {
        $status = $request->string('status')->toString();
        $search = trim($request->string('search')->toString());

        $messages = ContactMessage::query()
            ->when(in_array($status, ['new', 'reading', 'replied', 'closed'], true), fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($messageQuery) use ($search): void {
                    $messageQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%")
                        ->orWhere('internal_notes', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contact-messages-' . now()->format('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($messages): void {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");
            
            // CSV Header
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Subject', 'Message', 'Status', 'IP Address', 'Replied At', 'Created At', 'Internal Notes']);

            foreach ($messages as $message) {
                fputcsv($file, [
                    $message->id,
                    $this->csvSafe($message->name),
                    $this->csvSafe($message->email),
                    $this->csvSafe($message->phone),
                    $this->csvSafe($message->subject),
                    $this->csvSafe($message->message),
                    ucfirst($message->status),
                    $this->csvSafe($message->ip_address),
                    $message->replied_at ? $message->replied_at->format('Y-m-d H:i:s') : 'N/A',
                    $message->created_at->format('Y-m-d H:i:s'),
                    $this->csvSafe($message->internal_notes),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        ContactMessage::destroy($contactMessage->getKey());

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }

    private function csvSafe(?string $value): string
    {
        $value = (string) $value;

        if ($value !== '' && preg_match('/^[=+\-@]/', $value) === 1) {
            return "'".$value;
        }

        return $value;
    }
}
