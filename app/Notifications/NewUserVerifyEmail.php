<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Notifications\MustEmailVerify;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserVerifyEmail extends Notification
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
            'userVerification',
            Carbon::now()->addHours(1), //Config::get('auth.verification.expire', 60)
            [ "id" => $id, "hash" => $hash ]
        );

        $responseQuery = $this->responseQueryBuilder($id, $hash, $url);

        return (new MailMessage)
            ->view(
                'emails.new_user_email_verify',
                [
                    "user" => $this->user,
                    "url" => $url,
                    "query" => $responseQuery,
                ]
            );
    }

    private function responseQueryBuilder(string $id, string $hash, string $url): string
    {
        $urlQuery = (parse_url($url))["query"] ?? "";
        parse_str($urlQuery,$urlQueryArray);
        $urlQueryArray["id"] = $id;
        $urlQueryArray["hash"] = $hash;

        return http_build_query(
            $urlQueryArray,
            "",
            null,
            PHP_QUERY_RFC1738
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
