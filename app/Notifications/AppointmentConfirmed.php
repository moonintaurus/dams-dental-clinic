<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentConfirmed extends Notification
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        // This ensures the notification is sent via Email (Gmail)
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appointment Confirmed - DAMS Dental')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('Your appointment request at DAMS Dental Clinic has been confirmed.')
            ->line('**Date:** ' . $this->appointment->appointment_date->format('F j, Y'))
            ->line('**Time:** ' . date('g:i A', strtotime($this->appointment->appointment_time)))
            ->line('**Service:** ' . $this->appointment->service->name)
            ->action('View My Dashboard', url('/dashboard'))
            ->line('Please arrive 15 minutes before your scheduled time.')
            ->line('Thank you for choosing DAMS, we are pleasured to serve you!');
    }
}