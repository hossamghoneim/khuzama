<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification
{
    use Queueable;

    protected $email_token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email_token)
    {
        //
        $this->email_token = $email_token;
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
            ->subject('Email Activation')
            ->from(env('MAIL_USERNAMEs','test@mail.com'), config('app.name'))
            ->greeting(' Hello, '.$notifiable->name)
            ->line('You are receiving this email because we want to verify your account email.')
            ->action('Activate Email',
                route('account.settings.verifyEmailToken',['token'=>$this->email_token]))
            ->line('Thanks!');
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
