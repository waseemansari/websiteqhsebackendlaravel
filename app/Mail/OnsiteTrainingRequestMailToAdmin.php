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
        $requestType = $this->request->type === 'group' ? 'Group' : 'Individual';

        return new Envelope(
            subject: "New USA {$requestType} On-Site Training Request",
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
                'requestType' => $this->request->type === 'group' ? 'Group' : 'Individual',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}