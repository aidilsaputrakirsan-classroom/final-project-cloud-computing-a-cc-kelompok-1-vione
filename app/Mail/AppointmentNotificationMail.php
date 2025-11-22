<?php

namespace App\Mail;

use App\Models\Appointments;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointments $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */

    public function build()
{
    return $this->subject('New Appointment Request')
                ->view('emails.appointment_notification')
                ->with([
                    'appointment' => $this->appointment,
                    'health_condition' => $this->appointment->health_condition ?? 'Not specified',
                ]);
}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🐾 New Appointment Request Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
