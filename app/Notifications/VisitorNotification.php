<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitorNotification extends Notification
{
    use Queueable;
    public $mailVisitor;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mailVisitor)
    {
        $this->mailVisitor = $mailVisitor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            ->subject('Visitor Join Request')
            ->markdown('emails.visitorJoin', ['mailVisitor'=>$this->mailVisitor]);
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
            'user_id'=>$this->mailVisitor->user_id,
            'name'=>$this->mailVisitor->firstname,
            'contact'=>$this->mailVisitor->email,
            'start_date'=>$this->mailVisitor->start_datetime,
            'status'=> $this->mailVisitor->remark,
            'reason'=> "Joining an Event",
            'end_time'=> $this->mailVisitor->end_datetime,
        ];
    }
}
