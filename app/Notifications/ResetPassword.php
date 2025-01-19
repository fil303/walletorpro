<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Notifications\MustEmailVerify;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;
    protected User $user;
    /**
     * Create a new notification instance.
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
    public function toMail(MustEmailVerify $notifiable): MailMessage
    {
        $id   = $notifiable->getKey();
        $hash = sha1($notifiable->getEmailForVerification());
        $url  = URL::temporarySignedRoute(
            'passwordResetPage',
            Carbon::now()->addHours(1),
            [ "email" => $this->user->email ]
        );

        return (new MailMessage)
            ->view(
                'emails.reset-password',
                [
                    "user" => $this->user,
                    "url" => $url,
                ]
            );
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
