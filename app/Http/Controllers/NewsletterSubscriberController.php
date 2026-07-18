<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterBulkMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
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
         if($subscriber){
            $unsubscribeUrl = URL::signedRoute('news-letters.unsubscribe', ['subscriber' => $subscriber->id]);
            $recipientName = $subscriber->name ?? $subscriber->email;
            $message = <<<HTML
<p>Thank you for being part of the QHSE International community.</p>

<p>
This month, we have shared new educational blogs on the
<strong>QHSE International Knowledge Hub</strong>, created to support
professionals, organizations, and teams who want to strengthen their
knowledge in Quality, Health, Safety, Environment, ESG, Risk Management,
Fire and Life Safety, Emergency Preparedness, Business Continuity, and compliance.
</p>

<p>
Our blogs are designed to provide practical insights, expert guidance,
and industry-relevant knowledge that can help organizations improve performance,
protect people, manage risks, and build safer, stronger, and more resilient workplaces.
</p>

<p>
We invite you to visit the QHSE International website to read our latest articles
and continue learning from our team of experts.
</p>

<p style="text-align:center; margin:30px 0;">
    <a href="https://app.qhseinternational.com/blog/main"
       target="_blank"
       style="
            background:#0d6efd;
            color:#ffffff;
            padding:14px 28px;
            border-radius:6px;
            text-decoration:none;
            font-weight:bold;
            font-size:16px;
            font-family:Arial, Helvetica, sans-serif;
            display:inline-block;">
        📖 Read Our Latest Blogs
    </a>
</p>

<p>
Stay connected with us for more educational QHSE blogs, compliance insights,
industry updates, and practical safety guidance.
</p>
HTML;

Mail::to($subscriber->email)->send(
    new NewsletterBulkMail(
        'New QHSE Insights Are Now Available',
        $message,
        $recipientName,
        $unsubscribeUrl
    )
);
         }
       

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

        $subscribers = NewsletterSubscriber::where('status', 'subscribed')->get();

        foreach ($subscribers as $subscriber) {
            $unsubscribeUrl = URL::signedRoute('news-letters.unsubscribe', ['subscriber' => $subscriber->id]);
            $recipientName = $subscriber->name ?? $subscriber->email;

            Mail::to($subscriber->email)->send(
                new NewsletterBulkMail(
                    $request->subject,
                    $request->message,
                    $recipientName,
                    $unsubscribeUrl
                )
            );
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
    public function unsubscribe(NewsletterSubscriber $subscriber)
    {
        $subscriber->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);

        return view('newsletter.unsubscribed', compact('subscriber'));
    }
}