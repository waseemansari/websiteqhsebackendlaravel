<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBackAnswer extends Model
{
    protected $fillable = [
        'course_feedback_id',
        'question_no',
        'answer',
    ];
}
