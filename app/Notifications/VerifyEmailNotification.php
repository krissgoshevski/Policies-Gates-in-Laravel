<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;

     /**
     * Create a new notification instance.
     * 
     * 
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
   

    public function toMail($notifiable)
    {
        $verificationUrl = URL::signedRoute('verification.verify', ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->email)]);

    return (new MailMessage)
        ->greeting('Dear ' . $notifiable->name . ',')
        ->line('Thank you for registering. Please click the button below to verify your email address.')
        ->action('Verify Email Address', $verificationUrl)
        ->line('If you did not create an account, no further action is required.')
        ->salutation('Regards, Your Neotel Team');
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
