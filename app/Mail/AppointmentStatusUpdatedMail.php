<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointments;

class AppointmentStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointments $appointment)
    {
        $this->appointment = $appointment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🐾 Appointment Status Updated',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointmentstatusupdate',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
