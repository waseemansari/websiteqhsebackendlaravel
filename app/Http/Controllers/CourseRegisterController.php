<?php

namespace App\Http\Controllers;

use App\Models\CourseRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\CourseRegisterEvent;

class CourseRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CourseRegister::latest()->get());
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

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $course = CourseRegister::create($validator->validated());
        if($course){
            event(new CourseRegisterEvent($course));
        }
        
        return response()->json([
            'message' => 'Course Registered successfully our team will contact you soon Thanks',
            'data' => $course,
        ], 201);
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
}
