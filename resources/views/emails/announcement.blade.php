@component('mail::message')
# Important Announcement

Hello {{ $user->name }},

We have an important announcement from ONYXA Private Limited:

{{ $announcementMessage }}

---

You are receiving this email because you are a registered user of {{ setting('company_name', 'ONYXA') }}.

Thanks,<br>
{{ setting('company_name', 'ONYXA Private Limited') }}
@endcomponent
