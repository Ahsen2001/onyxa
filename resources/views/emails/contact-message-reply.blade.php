@component('mail::message')
# Reply to your inquiry

Hello {{ $contactMessage->name }},

Thank you for contacting ONYXA Private Limited. Here is our response to your inquiry:

{{ $replyMessage }}

---

**Your Original Message:**
> {{ $contactMessage->message }}

Thanks,<br>
{{ setting('company_name', 'ONYXA Private Limited') }}
@endcomponent
