@component('mail::message')
# New Contact Message

A new contact message has been submitted on the ONYXA website.

**Details:**
*   **Name:** {{ $contactMessage->name }}
*   **Email:** {{ $contactMessage->email }}
*   **Phone:** {{ $contactMessage->phone ?? 'N/A' }}
*   **IP Address:** {{ $contactMessage->ip_address ?? 'N/A' }}

**Subject:** {{ $contactMessage->subject ?: 'General Inquiry' }}

**Message:**
{{ $contactMessage->message }}

@component('mail::button', ['url' => route('admin.contact-messages.show', $contactMessage)])
View Message in Admin Panel
@endcomponent

Thanks,<br>
{{ config('app.name', 'ONYXA') }}
@endcomponent
