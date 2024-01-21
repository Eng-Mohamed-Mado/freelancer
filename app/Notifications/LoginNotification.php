<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;
    // Messages 
    public $message;
    // Subject
    public $subject;
    // Form E-Mail
    public $formEmail;
    // Mailer Send 
    public $mailer;


    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message = 'You Just Logged In';
        $this->subject = 'New Logged In';
        $this->formEmail = 'test@engineersof.com';
        $this->mailer = 'smtp';


    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
           ->mailer('smtp')
           ->subject($this->subject)
           ->greeting('Hello Der'.$notifiable->first_name)
           ->line($this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
