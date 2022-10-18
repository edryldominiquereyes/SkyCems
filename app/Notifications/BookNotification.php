<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookNotification extends Notification
{
    use Queueable;
    private $bookData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookData)
    {
        $this->bookData = $bookData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->subject('Facility Reservation Status')
                    ->markdown('emails.book', ['bookData'=>$this->bookData]);
                    // ->greeting($this->bookData['greeting'])
                    // ->line($this->bookData['body'])
                    // ->action($this->bookData['bookText'], $this->bookData['url'])
                    // ->line($this->bookData['thankyou']);         
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    
}
