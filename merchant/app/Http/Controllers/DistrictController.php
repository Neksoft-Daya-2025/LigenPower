<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::with('state')->orderBy('name')->paginate(10);
        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        $states = State::active()->orderBy('name')->get();
        return view('admin.districts.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        District::create($request->all());

        return redirect()->route('admin.districts.index')
            ->with('success', 'District created successfully!');
    }

    public function edit(District $district)
    {
        $states = State::active()->orderBy('name')->get();
        return view('admin.districts.edit', compact('district', 'states'));
    }

    public function update(Request $request, District $district)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $district->update($request->all());

        return redirect()->route('admin.districts.index')
            ->with('success', 'District updated successfully!');
    }

    public function destroy(District $district)
    {
        $district->delete();

        return redirect()->route('admin.districts.index')
            ->with('success', 'District deleted successfully!');
    }

    public function toggleStatus(District $district)
    {
        $district->update([
            'is_active' => !$district->is_active
        ]);

        $status = $district->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.districts.index')
            ->with('success', "District {$status} successfully!");
    }

    public function getByState(Request $request)
    {
        $districts = District::active()
            ->byState($request->state_id)
            ->orderBy('name')
            ->get();

        return response()->json($districts);
    }
}
