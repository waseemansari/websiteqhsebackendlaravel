<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
     protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'subject',
        'message',
        'hear_about',
        'status',
        'branch_id',
    ];
}
