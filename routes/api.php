<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CourseRegisterController,FeedBackController,ContactUsController};

Route::post('course-register', [CourseRegisterController::class, 'store']);
Route::post('contact-us', [ContactUsController::class, 'store']);
Route::post('feedback', [FeedBackController::class, 'store']);