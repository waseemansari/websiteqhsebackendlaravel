<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CourseRegisterController,ContactUsController};

Route::apiResource('course-register', CourseRegisterController::class);
Route::apiResource('contact-us', ContactUsController::class);