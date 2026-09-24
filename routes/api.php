<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{OnlinePaymentController,NewsletterSubscriberController,CourseRegisterController,FeedBackController,ContactUsController,PostController,OnsiteTrainingRequestController};
use App\Http\Controllers\Api\PaymentController;

Route::post('course-register', [CourseRegisterController::class, 'store']);
Route::post('contact-us', [ContactUsController::class, 'store']);
Route::post('feedback', [FeedBackController::class, 'store']);
Route::apiResource('onsite-training-requests', OnsiteTrainingRequestController::class);

Route::get('blog', [PostController::class, 'ApiGetBlogPosts']);
Route::get('blog/{id}', [PostController::class, 'ApiGetSingleBlogPost']);


Route::get('case-study', [PostController::class, 'caseStudy']);

Route::post('news-letters', [NewsletterSubscriberController::class, 'store']);

Route::post('payment', [OnlinePaymentController::class,'store']); 



Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);
Route::post('/stripe/checkout-success', [PaymentController::class, 'checkoutSuccess']);
Route::get('/stripe/checkout-success', [PaymentController::class, 'checkoutSuccess']);

Route::get('/course-list/{branch_id}', [CourseRegisterController::class, 'courseList']);