<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'course_registers_id',
        'course_id',
        'stripe_session_id',
        'stripe_payment_intent_id',
        'stripe_customer_id',
        'payment_method_id',
        'card_brand',
        'card_last4',
        'amount',
        'currency',
        'status',
    ];
    
}
