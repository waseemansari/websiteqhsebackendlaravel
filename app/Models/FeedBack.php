<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'course',
        'trainer',
        'other_specify',
        'enjoy',
        'profession',
        'comments',
        'enroll',
        'status',
        'branch_id',
    ];

    public function answers()
    {
        return $this->hasMany(FeedBackAnswer::class, 'course_feedback_id');
    }
}
