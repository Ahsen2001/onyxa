<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use App\Mail\AdminContactNotification;
use App\Mail\UserContactConfirmation;
use App\Mail\NewAdminNotification;
use App\Mail\PasswordResetMail;
use App\Mail\AnnouncementMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class NotificationMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_sends_admin_notification_and_user_confirmation(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'phone' => '1234567890',
            'subject' => 'General Inquiry',
            'message' => 'Hello ONYXA, love your products!',
        ]);

        $response->assertSessionHas('success');
        
        $message = ContactMessage::first();
        $this->assertNotNull($message);

        // Verify Admin Alert is queued
        Mail::assertQueued(AdminContactNotification::class, function ($mail) use ($message) {
            $adminEmail = setting('email', 'admin@onyxa.com');
            return $mail->hasTo($adminEmail) && $mail->contactMessage->id === $message->id;
        });

        // Verify User Confirmation is queued
        Mail::assertQueued(UserContactConfirmation::class, function ($mail) use ($message) {
            return $mail->hasTo('alice@example.com') && $mail->contactMessage->id === $message->id;
        });
    }

    public function test_new_admin_creation_triggers_new_admin_notification(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'New Administrator',
            'email' => 'newadmin@onyxa.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        Mail::assertQueued(NewAdminNotification::class, function ($mail) use ($admin) {
            return $mail->hasTo('newadmin@onyxa.com') && $mail->user->id === $admin->id;
        });
    }

    public function test_non_admin_creation_does_not_trigger_notification(): void
    {
        Mail::fake();

        User::create([
            'name' => 'Regular User',
            'email' => 'user@onyxa.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
            'status' => 'active',
        ]);

        Mail::assertNotQueued(NewAdminNotification::class);
    }

    public function test_password_reset_uses_custom_password_reset_mail(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Bob Test',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'status' => 'active',
        ]);

        $user->sendPasswordResetNotification('sample-reset-token');

        Mail::assertQueued(PasswordResetMail::class, function ($mail) use ($user) {
            return $mail->hasTo('bob@example.com') && 
                   $mail->user->id === $user->id && 
                   $mail->token === 'sample-reset-token';
        });
    }

    public function test_artisan_announcement_command_sends_emails_to_active_users_only(): void
    {
        Mail::fake();

        // 1. Create active admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin1@onyxa.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 2. Create active regular user
        $userActive = User::create([
            'name' => 'Active User',
            'email' => 'active@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'status' => 'active',
        ]);

        // 3. Create inactive user
        $userInactive = User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'status' => 'inactive',
        ]);

        // Run announcement command
        $exitCode = Artisan::call('onyx:announce', [
            '--subject' => 'Holiday Sale 2026',
            '--message' => 'Get 20% off all coconut bowls this week!',
        ]);

        $this->assertEquals(0, $exitCode);

        // Verify queued to active admin
        Mail::assertQueued(AnnouncementMail::class, function ($mail) {
            return $mail->hasTo('admin1@onyxa.com') && 
                   $mail->announcementSubject === 'Holiday Sale 2026' && 
                   $mail->announcementMessage === 'Get 20% off all coconut bowls this week!';
        });

        // Verify queued to active customer
        Mail::assertQueued(AnnouncementMail::class, function ($mail) {
            return $mail->hasTo('active@example.com');
        });

        // Verify NOT queued to inactive customer
        Mail::assertNotQueued(AnnouncementMail::class, function ($mail) {
            return $mail->hasTo('inactive@example.com');
        });
    }
}
