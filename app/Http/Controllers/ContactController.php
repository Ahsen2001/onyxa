<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('frontend.contact.index');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        unset($data['website']);
        $data['ip_address'] = $request->ip();
        $data['status'] = 'new';

        $contactMessage = ContactMessage::create($data);

        try {
            $adminEmail = setting('email', 'admin@onyxa.com');
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminContactNotification($contactMessage));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send contact notification email: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you. Your message has been sent successfully.');
    }
}
