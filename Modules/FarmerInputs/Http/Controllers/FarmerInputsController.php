<?php

namespace Modules\FarmerInputs\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Farmer;
use Modules\FarmerInputs\Models\FarmerInput;
use Modules\FarmerInputs\Models\InputType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FarmerInputsController extends Controller
{
    /**
     * Display a listing of farmer inputs.
     */
    public function index()
    {
        $inputs = FarmerInput::with(['farmer', 'inputType'])
            ->latest()
            ->paginate(10);
        return view('farmerinputs::inputs.index', compact('inputs'));
    }

    /**
     * Show the form for creating a new input.
     */
    public function create()
    {
        $farmers = Farmer::all();
        $inputTypes = InputType::all();
        return view('farmerinputs::inputs.create', compact('farmers', 'inputTypes'));
    }

    /**
     * Store a newly created input in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'input_type_id' => 'required|exists:input_types,id',
            'quantity' => 'required|integer|min:1',
            'distributed_date' => 'required|date|before_or_equal:today'
        ]);

        try {
            $farmerInput = new FarmerInput();
            $farmerInput->farmer_id = $validated['farmer_id'];
            $farmerInput->input_type_id = $validated['input_type_id'];
            $farmerInput->quantity = $validated['quantity'];
            $farmerInput->distributed_date = $validated['distributed_date'];
            $farmerInput->save();

            return redirect()
                ->route('farmer-inputs.index')
                ->with('success', 'Farming input distributed successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to distribute input: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified input.
     */
    public function edit($id)
    {
        $input = FarmerInput::findOrFail($id);
        $farmers = Farmer::all();
        $inputTypes = InputType::all();
        return view('farmerinputs::inputs.edit', compact('input', 'farmers', 'inputTypes'));

    }

    /**
     * Update the specified input in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'input_type_id' => 'required|exists:input_types,id',
            'quantity' => 'required|integer|min:1',
            'distributed_date' => 'required|date|before_or_equal:today'
        ]);

        try {
            $farmerInput = FarmerInput::findOrFail($id);
            $farmerInput->farmer_id = $validated['farmer_id'];
            $farmerInput->input_type_id = $validated['input_type_id'];
            $farmerInput->quantity = $validated['quantity'];
            $farmerInput->distributed_date = $validated['distributed_date'];
            $farmerInput->save();

            return redirect()
                ->route('farmer-inputs.index')
                ->with('success', 'Input distribution updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update input distribution: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified input from storage.
     */
    public function destroy($id)
    {
        try {
            $input = FarmerInput::findOrFail($id);
            $input->delete();

            return redirect()
                ->route('farmer-inputs.index')
                ->with('success', 'Input distribution deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting input distribution: ' . $e->getMessage());
        }
    }
}
