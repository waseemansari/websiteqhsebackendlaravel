<?php

use App\Models\Course;
use App\Models\CourseRegister;
use App\Models\Payment;
use Mockery;

it('creates a payment record when usa branch checkout starts', function () {
    config([
        'services.stripe.secret' => 'sk_test_123',
        'app.frontend_url' => 'http://localhost',
    ]);

    Course::unguard();
    $course = Course::create([
        'name' => 'Stripe Test Course',
        'branch_id' => 'usa',
        'price' => 149.99,
        'currency' => 'usd',
    ]);

    $mockSession = Mockery::mock('alias:Stripe\Checkout\Session');
    $mockSession->shouldReceive('create')->once()->andReturn((object) [
        'id' => 'cs_test_123',
        'url' => 'https://checkout.stripe.com/pay/cs_test_123',
        'payment_intent' => 'pi_test_123',
        'customer' => 'cus_test_123',
    ]);

    $response = $this->postJson('/api/course-register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'mobile' => '123456789',
        'location' => 'New York',
        'course' => $course->id,
        'hear_about' => 'Google',
        'branch_id' => 'usa',
    ]);

    $response->assertOk();

    $payment = Payment::where('stripe_session_id', 'cs_test_123')->first();

    expect($payment)->not->toBeNull()
        ->and($payment->course_registers_id)->toBe(CourseRegister::latest()->first()->id)
        ->and($payment->course_id)->toBe($course->id)
        ->and((string) $payment->amount)->toBe('149.99')
        ->and($payment->currency)->toBe('usd')
        ->and($payment->status)->toBe('pending');
});
