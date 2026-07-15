<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{NewsletterSubscriberController,CourseRegisterController,FeedBackController,ContactUsController,PostController};

Route::post('course-register', [CourseRegisterController::class, 'store']);
Route::post('contact-us', [ContactUsController::class, 'store']);
Route::post('feedback', [FeedBackController::class, 'store']);

Route::get('blog', [PostController::class, 'ApiGetBlogPosts']);
Route::get('blog/{id}', [PostController::class, 'ApiGetSingleBlogPost']);

Route::post('news-letters', [NewsletterSubscriberController::class, 'store']);