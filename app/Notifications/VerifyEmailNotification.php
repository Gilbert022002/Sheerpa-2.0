<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
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
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return (new MailMessage)
            ->subject('Vérifiez votre adresse email - Sheerpa')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Merci de vous être inscrit sur Sheerpa. Pour activer votre compte, veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous.')
            ->action('Vérifier mon email', $verificationUrl)
            ->line('Ou copiez-collez ce lien dans votre navigateur :')
            ->line($verificationUrl)
            ->line('Si vous n\'avez pas créé de compte, aucune action supplémentaire n\'est requise.')
            ->salutation('Cordialement, L\'équipe Sheerpa');
    }
}
