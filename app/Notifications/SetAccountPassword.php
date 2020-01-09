<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * The notification to set the account's password.
 */
class SetAccountPassword extends Notification
{
    use Queueable;

    /** @var string */
    private $actionUrl;

    /**
     * Create a new notification instance.
     *
     * @param string $actionUrl
     */
    public function __construct($actionUrl)
    {
        $this->actionUrl = $actionUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('notification.set_account_password.subject'))
            ->line(__('notification.set_account_password.body', ['appName' => config('app.name')]))
            ->action(__('notification.set_account_password.action_text'), $this->actionUrl)
            ->line(__('notification.set_account_password.footer'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
