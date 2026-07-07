<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseRegisterController;

Route::apiResource('course-register', CourseRegisterController::class);