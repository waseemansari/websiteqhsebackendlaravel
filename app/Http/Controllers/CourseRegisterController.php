<?php

namespace App\Http\Controllers;

use App\Models\{CourseRegister,Course,Payment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\CourseRegisterEvent;
use Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
class CourseRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $details = CourseRegister::where('branch_id', $branchId)->latest()->get();

        if ($request->expectsJson() && $request->is('api/*')) {
            return response()->json($details);
        }

        return view('course-register.index', compact('details'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|string',
            'location' => 'required|string',
            'course' => 'required|string',
            'hear_about' => 'required|string',
            'branch_id' => 'required|string',
        ]);
       
        $course = Course::findorfail($request->course);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        $CourseRegister = CourseRegister::create($validator->validated());
        if($CourseRegister){
            event(new CourseRegisterEvent($CourseRegister));
        }
        if($request->branch_id  !== 'usa'){
             return response()->json([
                    'message' => 'Course Registered successfully our team will contact you soon Thanks',
                    'data' => $CourseRegister,
                ], 201);
        }
        /////////////////
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $session = Session::create([
                'mode' => 'payment',
                'customer_email' => $request->email,
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $course->currency,
                            'product_data' => [
                                'name' =>"Course Name : " . $course->name,
                            ],
                            'unit_amount' => (int) round($course->price * 100),
                        ],
                        'quantity' => 1,
                    ],
                ],
                'metadata' => [
                   'course_id' => (string) $course->id,
                ],
                'success_url' =>config('app.frontend_url').'/'.$request->branch_id.'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' =>config('app.frontend_url').'/'.$request->branch_id.'?cancel=isCancelled',
            ]);
              
            Payment::create([
                'course_registers_id' => $CourseRegister->id,
                'course_id' => $course->id,
                'stripe_session_id' => $session->id,
                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                'stripe_customer_id' => $session->customer ?? null,
                'amount' => (float) $course->price,
                'currency' => $course->currency ?? 'usd',
                'status' => 'pending',
                'card_brand' => $session->payment_method_types[0] ?? null,
                'card_last4' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Course Registered successfully our team will contact you soon Thanks',
                'data' => $CourseRegister,
                'checkout_url' =>
                    $session->url,
                'stripe_session_id' =>
                    $session->id,
            ]);


        } catch (\Exception $e) {
            $CourseRegister->delete();
            return response()->json([
                'success' => false,
                'message' =>'Unable to create payment.',
                'error' =>$e->getMessage(),
            ], 500);
        }
        //////////////////
       
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseRegister $courseRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseRegister $courseRegister)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseRegister $courseRegister)
    {
        //
    }
    //////////////course list 
    public function courseList(Request $request, $branch_id)
    {
        $details = Course::where('branch_id', $branch_id)->latest()->get(); // Adjust the selected columns as needed

        if ($request->expectsJson() && $request->is('api/*')) {
            return response()->json($details);
        }
    }
}
