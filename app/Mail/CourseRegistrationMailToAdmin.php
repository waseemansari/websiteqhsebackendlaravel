<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\CourseRegister;

class CourseRegistrationMailToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $course;
    public $company;

    public function __construct(CourseRegister $course)
    {
        $this->course = $course;
        $this->company = config('custom');
    }

    /**
     * Get the message envelope.
     */
   public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Student Registered to QHSE International ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        
         return new Content(
            view: 'emails.course_register_to_admin',
            with: [
                'course' => $this->course,
                'company' => $this->company,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
