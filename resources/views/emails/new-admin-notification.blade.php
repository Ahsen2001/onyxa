@component('mail::message')
# Welcome to ONYXA Admin Panel

Hello {{ $user->name }},

An administrator account has been created for you on the ONYXA admin dashboard.

**Account Details:**
*   **Email:** {{ $user->email }}
*   **Role:** {{ ucfirst($user->role) }}

Please use your registered email and password to log in. If you do not have your password, you can use the password reset option at the login page.

@component('mail::button', ['url' => route('admin.login')])
Log In to Admin Panel
@endcomponent

Thanks,<br>
{{ setting('company_name', 'ONYXA Private Limited') }}
@endcomponent
