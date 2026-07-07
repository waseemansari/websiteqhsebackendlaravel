<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
