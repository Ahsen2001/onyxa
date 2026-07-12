<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMessageReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public ContactMessage $contactMessage;
    public string $replyMessage;
    public string $replySubject;

    public function __construct(ContactMessage $contactMessage, string $replySubject, string $replyMessage)
    {
        $this->contactMessage = $contactMessage;
        $this->replySubject = $replySubject;
        $this->replyMessage = $replyMessage;
    }

    public function build()
    {
        return $this->subject($this->replySubject)
            ->markdown('emails.contact-message-reply');
    }
}
