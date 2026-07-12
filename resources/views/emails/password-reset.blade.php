@component('mail::message')
# Reset Password

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => url('/password/reset/' . $token . '?email=' . urlencode($user->email))])
Reset Password
@endcomponent

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ setting('company_name', 'ONYXA Private Limited') }}
@endcomponent
