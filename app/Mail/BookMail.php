<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookMail extends Mailable
{
    use Queueable, SerializesModels;
    private $bookData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bookData)
    {
        $this->bookData = $bookData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.book');
    }
}
