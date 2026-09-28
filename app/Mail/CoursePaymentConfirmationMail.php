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

class CoursePaymentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $company;
    public function __construct(
        public CourseRegister $registration,
        public Course $course,
        public Payment $payment,
        
        
    ) {
        $this->company = config('custom');
        
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course registration and payment confirmed',
        );
    }

    public function content(): Content
    {
        $branchId = strtolower(trim($this->registration->branch_id));
        $branch = config('custom.branches.' . $branchId, []);

        return new Content(
            view: 'emails.course_payment_confirmation',
            with: [
                'branch' => $branch,
                'company' => $this->company,
                'companyName' => $branch['name'] ?? config('custom.company_name'),
                'firstName' => explode(' ', trim($this->registration->name), 2)[0],
                'courseDates' => 'To be confirmed',
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