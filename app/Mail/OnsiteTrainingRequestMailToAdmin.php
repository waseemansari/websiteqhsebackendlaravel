<?php

namespace App\Mail;

use App\Models\OnsiteTrainingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnsiteTrainingRequestMailToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OnsiteTrainingRequest $request)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New USA On-Site Training Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.onsite_training_request_to_admin',
            with: [
                'company' => config('custom'),
                'branch' => config('custom.branches.' . $this->request->branch_id, []),
                'isAdmin' => true,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}