<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterBulkMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $subjectLine;
    public string $messageBody;
    public $company;
    public $recipientName;
    
    public function __construct(string $subjectLine, string $messageBody, string $recipientName = null)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
        $this->recipientName = $recipientName;
        $this->company = config('custom');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter_bulk',
            with: [
                'subject' => $this->subjectLine,
                'messageBody' => $this->messageBody,
                'company' => $this->company,
                'recipientName' => $this->recipientName,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
