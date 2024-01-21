<?php

namespace App\Notifications;

use Ichtrojan\Otp\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class EmailVerificationNotification extends Notification
{
    use Queueable;
    // Message 
    public $message;
    // Subject
    public $subject;
    // FromEmail
    public $fromEmail;
    // Mailar
    public $mailar;
    // OTP
    public $otp;
    

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message = 'You Just Logged In';
        $this->subject = 'New Logged In';
        $this->fromEmail = 'test@engineersof.com';
        $this->mailar ='smtp';
        $this->otp = new Otp;

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
                                   // Email User , Number Otp , Time Expare
        $otp = $this->otp->generate($notifiable->email,6,15);
        return (new MailMessage)
        ->mailer('smtp')
        ->subject($this->subject)
        ->greeting('Hello Der'.$notifiable->first_name)
        ->line($this->message)
        ->line('code: '. $otp->token);
        
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
