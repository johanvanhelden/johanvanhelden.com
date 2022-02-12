<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetAccountPassword extends Notification
{
    use Queueable;

    public function __construct(
        private string $actionUrl
    ) {
    }

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('notification.set_account_password.subject'))
            ->line(__('notification.set_account_password.body', ['appName' => config('app.name')]))
            ->action(__('notification.set_account_password.action_text'), $this->actionUrl)
            ->line(__('notification.set_account_password.footer'));
    }
}
