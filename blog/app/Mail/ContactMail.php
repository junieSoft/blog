<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {

        $this->data = $data;
    }

    /**
     * Build the message.
     * @author junietoukem@gmail.com
     * @return $this
     */
    public function build()
    {

        return $this->subject('New Announcement')
        ->from('test@test.com')
        
        ->markdown('emails.contact.contact-form');
    }
}
