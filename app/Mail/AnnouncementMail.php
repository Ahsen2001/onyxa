<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnnouncementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public string $announcementSubject;
    public string $announcementMessage;

    public function __construct(User $user, string $subject, string $message)
    {
        $this->user = $user;
        $this->announcementSubject = $subject;
        $this->announcementMessage = $message;
    }

    public function build()
    {
        return $this->subject($this->announcementSubject)
            ->markdown('emails.announcement');
    }
}
