<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterBulkMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterSubscriberController extends Controller
{
    /**
     * Display all subscribers.
     */
    public function index()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(20);

        return view('newsletter.index', compact('subscribers'));
    }

    /**
     * Store a new subscriber.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:newsletter_subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $subscriber = NewsletterSubscriber::create([
            'name' => strtok($request->email, '@'),
            'email' => strtolower($request->email),
            'status' => 'subscribed',
            'verified_at' => now(),
            'ip_address' => $request->ip(),
            'source' => $request->source ?? 'website',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to the newsletter.',
            'data' => $subscriber,
        ], 201);
    }

    /**
     * Show a subscriber.
     */
    public function show(Request $request, $id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);

        if ($request->expectsJson() && $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $subscriber,
            ]);
        }

        return view('newsletter.show', compact('subscriber'));
    }

    /**
     * Update subscriber.
     */
    public function update(Request $request, $id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'status' => 'required|in:pending,subscribed,unsubscribed',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $subscriber->update([
            'name' => $request->name,
            'status' => $request->status,
            'unsubscribed_at' => $request->status === 'unsubscribed'
                ? now()
                : null,
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Subscriber updated successfully.',
                'data' => $subscriber,
            ]);
        }

        return redirect()->route('news-letters.show', $subscriber)
            ->with('success', 'Subscriber updated successfully.');
    }

    /**
     * Show bulk email form.
     */
    public function bulk()
    {
        return view('newsletter.bulk');
    }

    /**
     * Send bulk newsletter email.
     */
    public function sendBulk(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $subscribers = NewsletterSubscriber::where('status', '=', 'subscribed')->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterBulkMail($request->subject, $request->message, $subscriber->name));
        }

        return redirect()->route('news-letters.bulk')
            ->with('success', 'Bulk newsletter email sent to all active subscribers.');
    }

    /**
     * Delete subscriber.
     */
    public function destroy($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);

        $subscriber->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscriber deleted successfully.',
        ]);
    }

    /**
     * Unsubscribe by email.
     */
    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = NewsletterSubscriber::where('email', $request->email)->first();

        if (!$subscriber) {
            return response()->json([
                'success' => false,
                'message' => 'Subscriber not found.',
            ], 404);
        }

        $subscriber->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You have been unsubscribed successfully.',
        ]);
    }
}