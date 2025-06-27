<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Verifikasi Email Anda')
            ->greeting('Halo!')
            ->line('Silakan klik tombol di bawah ini untuk verifikasi email akun Anda.')
            ->action('Verifikasi Email', $verificationUrl)
            ->line('Jika Anda tidak mendaftar, abaikan email ini.');
    }

    protected function verificationUrl($notifiable)
    {
        $appUrl = config('app.url');
        $route = URL::temporarySignedRoute(
            'verification.verify.public',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
        return $route;
    }
} 