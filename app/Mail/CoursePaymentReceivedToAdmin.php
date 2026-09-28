<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\CourseRegister;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CoursePaymentReceivedToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CourseRegister $registration,
        public Course $course,
        public Payment $payment,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course payment received: ' . $this->registration->name,
        );
    }

    public function content(): Content
    {
        $branchId = strtolower(trim($this->registration->branch_id));

        return new Content(
            view: 'emails.course_payment_received_to_admin',
            with: [
                'company' => config('custom'),
                'branch' => config('custom.branches.' . $branchId, []),
                'locationFormat' => implode(' / ', array_filter([
                    $this->course->mode,
                    $this->registration->location,
                ])),
                'transactionNumber' => $this->payment->stripe_payment_intent_id
                    ?? $this->payment->stripe_session_id,
            ],
        );
    }
}