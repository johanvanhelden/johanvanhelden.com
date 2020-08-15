<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetAccountPassword extends Notification
{
    use Queueable;

    private string $actionUrl;

    public function __construct(string $actionUrl)
    {
        $this->actionUrl = $actionUrl;
    }

    /**
     * @param mixed $notifiable
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param mixed $notifiable
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('notification.set_account_password.subject'))
            ->line(__('notification.set_account_password.body', ['appName' => config('app.name')]))
            ->action(__('notification.set_account_password.action_text'), $this->actionUrl)
            ->line(__('notification.set_account_password.footer'));
    }
}
