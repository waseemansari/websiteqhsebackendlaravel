<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\{ContactUsMailToAdmin};
use Illuminate\Support\Facades\Mail;
use Auth;
class ContactUsController extends Controller
{
     public function index(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $details = ContactUs::where('branch_id', $branchId)->latest()->get();

        if ($request->expectsJson() && $request->is('api/*')) {
            return response()->json($details);
        }

        return view('contact-us.index', compact('details'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
            'hear_about' => 'required|string',
            'branch_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $detail = ContactUs::create($validator->validated());
         $adminEmail = config('custom.branch_emails.' . $detail->branch_id)
        ?? config('custom.company_email');

        Mail::to($adminEmail)->send(new ContactUsMailToAdmin($detail));
        
        return response()->json([
            'message' => 'Your request sent successfully our team will contact you soon Thanks',
            'data' => $detail,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
