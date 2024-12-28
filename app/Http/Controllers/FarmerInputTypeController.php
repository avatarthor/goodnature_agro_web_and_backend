<?php

namespace App\Http\Controllers;

use App\Models\InputType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FarmerInputTypeController extends Controller
{
    /**
     * Display a listing of input types.
     */
    public function index()
    {
        $inputTypes = InputType::latest()->paginate(10);
        return view('farmer-input-types.index', compact('inputTypes'));
    }

    /**
     * Show the form for creating a new input type.
     */
    public function create()
    {
        return view('farmer-input-types.create');
    }

    /**
     * Store a newly created input type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:input_types',
            'description' => 'required|string'
        ]);

        try {
            $inputType = new InputType();
            $inputType->name = $validated['name'];
            $inputType->description = $validated['description'];
            $inputType->save();

            return redirect()
                ->route('farmer-input-types.index')
                ->with('success', 'Input type created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create input type: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified input type.
     */
    public function edit($id)
    {
        $inputType = InputType::findOrFail($id);
        return view('farmer-input-types.edit', compact('inputType'));
    }

    /**
     * Update the specified input type in storage.
     */
    public function update(Request $request, $id)
    {
        $inputType = InputType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:input_types,name,' . $id,
            'description' => 'required|string'
        ]);

        try {
            $inputType->name = $validated['name'];
            $inputType->description = $validated['description'];
            $inputType->save();

            return redirect()
                ->route('farmer-input-types.index')
                ->with('success', 'Input type updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update input type: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified input type from storage.
     */
    public function destroy($id)
    {
        try {
            $inputType = InputType::findOrFail($id);

            // Check if input type is being used by any farmer inputs
            if ($inputType->farmerInputs()->count() > 0) {
                throw new \Exception('Cannot delete input type that is being used by farmers');
            }

            $inputType->delete();
            return redirect()
                ->route('farmer-input-types.index')
                ->with('success', 'Input type deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting input type: ' . $e->getMessage());
        }
    }
}
