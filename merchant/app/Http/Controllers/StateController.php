<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    public function index()
    {
        $states = State::orderBy('name')->paginate(10);
        return view('admin.states.index', compact('states'));
    }

    public function create()
    {
        return view('admin.states.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:states,name',
            'code' => 'required|string|max:10|unique:states,code',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        State::create($request->all());

        return redirect()->route('admin.states.index')
            ->with('success', 'State created successfully!');
    }

    public function edit(State $state)
    {
        return view('admin.states.edit', compact('state'));
    }

    public function update(Request $request, State $state)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:states,name,' . $state->id,
            'code' => 'required|string|max:10|unique:states,code,' . $state->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $state->update($request->all());

        return redirect()->route('admin.states.index')
            ->with('success', 'State updated successfully!');
    }

    public function destroy(State $state)
    {
        $state->delete();

        return redirect()->route('admin.states.index')
            ->with('success', 'State deleted successfully!');
    }

    public function toggleStatus(State $state)
    {
        $state->update([
            'is_active' => !$state->is_active
        ]);

        $status = $state->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.states.index')
            ->with('success', "State {$status} successfully!");
    }
}
