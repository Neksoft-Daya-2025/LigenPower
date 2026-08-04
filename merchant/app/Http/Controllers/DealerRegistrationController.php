<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DealerRegistrationController extends Controller
{
    public function showForm()
    {
        $states = State::active()->orderBy('name')->get();
        return view('register', compact('states'));
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->createPendingDealer($request->all());

        return redirect()->route('register')->with('success',
            'Thank you! Your registration has been submitted. Our team will review it and you will appear on the store locator after approval.');
    }

    public function apiStore(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $dealer = $this->createPendingDealer($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Registration submitted successfully. You will be listed after admin approval.',
            'id' => $dealer->id,
        ]);
    }

    public function apiStates()
    {
        $states = State::active()->orderBy('name')->get(['id', 'name']);
        return response()->json(['success' => true, 'states' => $states]);
    }

    public function apiDistricts(Request $request)
    {
        $request->validate(['state_id' => 'required|exists:states,id']);
        $districts = District::active()
            ->byState($request->state_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['success' => true, 'districts' => $districts]);
    }

    private function validator(array $data)
    {
        $rules = Dealer::validationRules();
        $rules['email'] = 'nullable|email|unique:dealers,email';

        return Validator::make($data, $rules);
    }

    private function createPendingDealer(array $input): Dealer
    {
        $district = District::find($input['district_id']);
        $state = State::find($input['state_id']);

        $data = $input;
        $data['city'] = $district ? $district->name : ($input['city'] ?? null);
        $data['state'] = $state ? $state->name : ($input['state'] ?? null);
        $data['email'] = !empty($input['email']) ? $input['email'] : null;
        $data['status'] = 'inactive';
        $data['business_description'] = $input['business_description']
            ?? 'Self-registered via ligenpower.com — pending admin approval.';

        return Dealer::create($data);
    }
}
