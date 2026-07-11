<?php

namespace App\Http\Controllers;

use App\Models\{FeedBack,FeedBackAnswer};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;


class FeedBackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $feedbacks = FeedBack::where('branch_id', $branchId)->latest()->get();

        if ($request->expectsJson() && $request->is('api/*')) {
            return response()->json($feedbacks);
        }

        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            DB::beginTransaction();
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
            'course' => 'required|string',
            'trainer' => 'required|string',
            'enjoy' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'comments' => 'required|string|max:255',
            'enroll' => 'required|string',
            'branch_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $feedback = FeedBack::create($validator->validated());
         foreach ($request->all() as $key => $value) {

            if (is_numeric($key)) {

                FeedbackAnswer::create([
                    'feedback_id' => $feedback->id,
                    'question_no'        => $key,
                    'answer'             => $value,
                ]);
            }
        }

        if ($request->expectsJson()) {
            DB::commit();

            return response()->json([
                'message' => 'Your Feedback sent successfully our team will contact you soon Thanks',
                'data' => $feedback,
            ], 201);
        }

        DB::commit();

        return redirect()->route('feedback.index')->with('success', 'Your feedback has been submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $feedBack = FeedBack::findOrFail($id);

        $feedBack->update([
            'status' => 'readed',
        ]);

        $answers = $feedBack->answers()
            ->orderBy('question_no')
            ->get();

        return view('feedback.show', compact('feedBack', 'answers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeedBack $feedBack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeedBack $feedBack)
    {
        //
    }
}
