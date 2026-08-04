<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $states = State::active()->orderBy('name')->get();
        return view('search.index', compact('states'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id'
        ]);

        // Get district name for city search
        $district = District::find($request->district_id);
        $districtName = $district ? $district->name : '';

        $query = Dealer::active()
            ->with(['state', 'district'])
            ->byState($request->state_id)
            ->where(function($q) use ($request, $districtName) {
                $q->byDistrict($request->district_id)
                  ->orWhere('city', 'like', '%' . $districtName . '%');
            });

        $results = $query->orderBy('business_name')->get();

        return view('search.results', compact('results', 'request'));
    }

    public function getDistricts(Request $request)
    {
        $districts = District::active()
            ->byState($request->state_id)
            ->orderBy('name')
            ->get();

        return response()->json($districts);
    }
}
