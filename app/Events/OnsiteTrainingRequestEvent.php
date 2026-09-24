<?php

namespace App\Events;

use App\Models\OnsiteTrainingRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnsiteTrainingRequestEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public OnsiteTrainingRequest $request)
    {
    }
}