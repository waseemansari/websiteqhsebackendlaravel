<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{OnlinePaymentController,NewsletterSubscriberController,PostController,CourseRegisterController,FeedBackController,ContactUsController};

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::Resource('course-register', CourseRegisterController::class);
    Route::Resource('contact-us', ContactUsController::class);
    Route::Resource('feedback', FeedBackController::class);
    Route::resource('post', PostController::class);
    Route::get('news-letters/bulk', [NewsletterSubscriberController::class, 'bulk'])->name('news-letters.bulk');
    Route::post('news-letters/bulk-send', [NewsletterSubscriberController::class, 'sendBulk'])->name('news-letters.bulk.send');
    Route::get('news-letters/unsubscribe/{subscriber}', [NewsletterSubscriberController::class, 'unsubscribe'])->middleware('signed')->name('news-letters.unsubscribe');
    Route::Resource('news-letters', NewsletterSubscriberController::class);
});

    Route::get('payment', [OnlinePaymentController::class,'create']);
    Route::post('payment', [OnlinePaymentController::class,'store']);

    Route::post('/payment/response', [OnlinePaymentController::class, 'response'])
    ->name('ccavenue.response');














require __DIR__.'/auth.php';
