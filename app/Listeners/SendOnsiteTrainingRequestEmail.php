<?php

namespace App\Listeners;

use App\Events\OnsiteTrainingRequestEvent;
use App\Mail\OnsiteTrainingRequestMailToAdmin;
use App\Mail\OnsiteTrainingRequestMailToUser;
use Illuminate\Support\Facades\Mail;

class SendOnsiteTrainingRequestEmail
{
    public function handle(OnsiteTrainingRequestEvent $event): void
    {
        $onsiteRequest = $event->request;
        $adminEmail = config('custom.branch_emails.' . $onsiteRequest->branch_id)
            ?? config('custom.company_email');

        Mail::to($adminEmail)
            ->send(new OnsiteTrainingRequestMailToAdmin($onsiteRequest));

        Mail::to($onsiteRequest->work_email)
            ->send(new OnsiteTrainingRequestMailToUser($onsiteRequest));
    }///
}