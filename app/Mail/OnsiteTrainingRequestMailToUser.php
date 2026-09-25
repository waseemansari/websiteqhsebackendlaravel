<?php

namespace App\Mail;

use App\Models\OnsiteTrainingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnsiteTrainingRequestMailToUser extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OnsiteTrainingRequest $request)
    {
    }

    public function envelope(): Envelope
    {
        $requestType = $this->request->type === 'group' ? 'group' : 'individual';

        return new Envelope(
            subject: "We received your {$requestType} on-site training request",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.onsite_training_request_to_user',
            with: [
                'company' => config('custom'),
                'branch' => config('custom.branches.' . $this->request->branch_id, []),
                'requestType' => $this->request->type === 'group' ? 'Group' : 'Individual',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}