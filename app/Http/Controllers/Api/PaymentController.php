<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        // Always set your secret key securely on the backend
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // In a production app, fetch the product price from your database securely
            $amount = 5000; // Amount in cents ($50.00)

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkoutSuccess(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($request->session_id);
            $paymentIntentId = $session->payment_intent;
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            $charge = $paymentIntent->charges->data[0] ?? null;
            $brand = $charge?->payment_method_details?->card?->brand ?? null;
            $last4 = $charge?->payment_method_details?->card?->last4 ?? null;
            $paymentMethodId = $paymentIntent->payment_method;

            $payment = Payment::where('stripe_session_id', $request->session_id)->first();

            if ($payment) {
                $payment->update([
                    'stripe_payment_intent_id' => $paymentIntent->id,
                    'stripe_customer_id' => $session->customer ?? $paymentIntent->customer,
                    'payment_method_id' => $paymentMethodId,
                    'card_brand' => $brand,
                    'card_last4' => $last4,
                    'status' => $paymentIntent->status === 'succeeded' ? 'paid' : 'pending',
                ]);
            }

            return response()->json([
                'success' => true,
                'brand' => $brand,
                'last4' => $last4,
                'payment_intent_id' => $paymentIntent->id,
                'payment' => $payment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch Stripe payment details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}