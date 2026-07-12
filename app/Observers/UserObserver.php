<?php

namespace App\Observers;

use App\Models\User;
use App\Mail\NewAdminNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user): void
    {
        if ($user->role === 'admin') {
            try {
                Mail::to($user->email)->send(new NewAdminNotification($user));
            } catch (\Exception $e) {
                Log::error('Failed to send welcome email to new admin: ' . $e->getMessage());
            }
        }
    }
}
