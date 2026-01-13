<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentCompleted extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Thank You for Visiting DAMS Dental')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('Your appointment for ' . $this->appointment->service->name . ' is now marked as completed.')
            ->line('We hope you had a great experience at DAMS Dental Clinic.')
            ->action('View My Medical Records', url('/medical-records'))
            ->line('You can now view your updated treatment history in your dashboard.')
            ->line('If you have any post-treatment questions, feel free to contact us.')
            ->line('Keep smiling!');
    }
}