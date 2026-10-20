<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseRegister extends Model
{
      protected $fillable = [
        'name',
        'email',
        'mobile',
        'location',
        'course',
        'hear_about',
        'status',
        'branch_id',
        'company',
        'participant',
        'type',
        'preferred_date',
        'course_type',
    ];

    public function courseInfo(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course');
    }
}
