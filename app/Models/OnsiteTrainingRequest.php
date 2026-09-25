<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnsiteTrainingRequest extends Model
{
    protected $fillable = [
        'company_name',
        'type',
        'branch_id',
        'contact_name',
        'work_email',
        'phone',
        'facility_address',
        'city',
        'state',
        'zip_code',
        'training_needs',
        'number_of_participants',
        'equipment_conditions',
        'preferred_dates',
        'additional_details',
        'training_topic',
        'delivery_preference',
        'status',
    ];
}