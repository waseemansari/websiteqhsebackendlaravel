<?php

namespace App\Http\Controllers;

use App\Events\OnsiteTrainingRequestEvent;
use App\Models\OnsiteTrainingRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OnsiteTrainingRequestController extends Controller
{
    public function index()
    {
        return response()->json(OnsiteTrainingRequest::latest()->get());
    }

    public function store(Request $request)
    {
        $onsiteRequest = OnsiteTrainingRequest::create($request->validate($this->rules()));
        event(new OnsiteTrainingRequestEvent($onsiteRequest));
       
        return response()->json([
            'message' => 'Your onsite training request was submitted successfully.',
            'data' => $onsiteRequest,
        ], 201);
    }

    public function show(OnsiteTrainingRequest $onsiteTrainingRequest)
    {
        return response()->json($onsiteTrainingRequest);
    }

    public function update(Request $request, OnsiteTrainingRequest $onsiteTrainingRequest)
    {
        $onsiteTrainingRequest->update($request->validate($this->rules(true)));

        return response()->json([
            'message' => 'Onsite training request updated successfully.',
            'data' => $onsiteTrainingRequest->fresh(),
        ]);
    }

    public function destroy(OnsiteTrainingRequest $onsiteTrainingRequest)
    {
        $onsiteTrainingRequest->delete();

        return response()->json(['message' => 'Onsite training request deleted successfully.']);
    }

    private function rules(bool $updating = false): array
    {
        $required = $updating ? 'sometimes' : 'required';

        return [
            'company_name' => [$required, 'string', 'max:255'],
            'branch_id' => [$updating ? 'sometimes' : 'nullable', 'string', 'max:100'],
            'contact_name' => [$required, 'string', 'max:255'],
            'work_email' => [$required, 'email', 'max:255'],
            'phone' => [$required, 'string', 'max:50'],
            'facility_address' => [$required, 'string', 'max:255'],
            'city' => [$required, 'string', 'max:100'],
            'state' => [$required, 'string', 'max:100'],
            'zip_code' => [$required, 'string', 'max:20'],
            'training_needs' => [$required, 'string'],
            'number_of_participants' => [$required, 'integer', 'min:1'],
            'equipment_conditions' => [$required, 'string'],
            'preferred_dates' => [$required, 'string'],
            'additional_details' => ['nullable', 'string'],
            'status' => [$updating ? 'sometimes' : 'nullable', Rule::in(['new', 'contacted', 'completed', 'cancelled'])],
        ];
    }
}