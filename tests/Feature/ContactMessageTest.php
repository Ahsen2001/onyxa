<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use App\Mail\AdminContactNotification;
use App\Mail\ContactMessageReply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user for authentication in admin feature tests
        $this->adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@onyxa.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }

    public function test_contact_submission_creates_record_and_sends_notification(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'subject' => 'Wholesale Inquiry',
            'message' => 'Hello, I want to buy 100 cups.',
        ]);

        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'status' => 'new',
        ]);

        $message = ContactMessage::first();

        Mail::assertSent(AdminContactNotification::class, function ($mail) use ($message) {
            return $mail->contactMessage->id === $message->id;
        });
    }

    public function test_viewing_new_message_transitions_status_to_reading(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hello',
            'message' => 'Is this available?',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.contact-messages.show', $message));

        $response->assertStatus(200);

        // Verify status changed to reading
        $this->assertEquals('reading', $message->fresh()->status);
        $this->assertTrue((bool) $message->fresh()->is_read);
    }

    public function test_admin_can_update_status_manually(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hello',
            'message' => 'Is this available?',
            'status' => 'reading',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->patch(route('admin.contact-messages.status', $message), [
                'status' => 'closed',
            ]);

        $response->assertRedirect();
        $this->assertEquals('closed', $message->fresh()->status);
    }

    public function test_admin_can_update_internal_notes(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hello',
            'message' => 'Is this available?',
            'status' => 'reading',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->patch(route('admin.contact-messages.notes', $message), [
                'internal_notes' => 'Called user on 2026-07-12, left a voicemail.',
            ]);

        $response->assertRedirect();
        $this->assertEquals('Called user on 2026-07-12, left a voicemail.', $message->fresh()->internal_notes);
    }

    public function test_admin_can_reply_via_email(): void
    {
        Mail::fake();

        $message = ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hello',
            'message' => 'Is this available?',
            'status' => 'reading',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.contact-messages.reply', $message), [
                'reply_subject' => 'Re: Hello',
                'reply_message' => 'Yes, it is available in stock.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $message = $message->fresh();
        $this->assertEquals('replied', $message->status);
        $this->assertNotNull($message->replied_at);

        Mail::assertSent(ContactMessageReply::class, function ($mail) use ($message) {
            return $mail->contactMessage->id === $message->id && 
                   $mail->replySubject === 'Re: Hello' &&
                   $mail->replyMessage === 'Yes, it is available in stock.';
        });
    }

    public function test_admin_can_export_csv(): void
    {
        ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hello',
            'message' => 'Is this available?',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.contact-messages.export'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        
        $content = $response->streamedContent();
        $this->assertStringContainsString('Jane Doe', $content);
        $this->assertStringContainsString('jane@example.com', $content);
        $this->assertStringContainsString('New', $content); // ucwords status
    }
}
