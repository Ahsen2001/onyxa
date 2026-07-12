@component('mail::message')
# Inquiry Received

Hello {{ $contactMessage->name }},

Thank you for contacting ONYXA Private Limited. We have successfully received your inquiry and our team is currently reviewing it.

**Inquiry Summary:**
*   **Subject:** {{ $contactMessage->subject ?: 'General Inquiry' }}
*   **Message:**
    {{ $contactMessage->message }}

We will get back to you as soon as possible, usually within 1-2 business days.

Thanks,<br>
{{ setting('company_name', 'ONYXA Private Limited') }}
@endcomponent
