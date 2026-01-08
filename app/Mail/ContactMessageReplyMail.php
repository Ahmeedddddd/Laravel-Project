<?php
}
    }
            ->view('mail.contact-reply');
            ->subject('Antwoord op je contactbericht: '.$this->message->subject)
        return $this
    {
    public function build(): self

    }
    {
    public function __construct(public ContactMessage $message)

    use Queueable, SerializesModels;
{
class ContactMessageReplyMail extends Mailable

use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use App\Models\ContactMessage;

namespace App\Mail;


