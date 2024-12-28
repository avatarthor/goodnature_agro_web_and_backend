<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    /**
     * Display a listing of the farmers.
     */
    public function index()
    {
        $farmers = Farmer::all();
        return view('farmers.index', compact('farmers'));
    }

    /**
     * Show the form for creating a new farmer.
     */
    public function create()
    {
        return view('farmers.create');
    }

    /**
     * Store a newly created farmer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'location' => 'required|string|max:255',
        ]);

        $farmer = new Farmer();
        $farmer->name = $request->name;
        $farmer->phone_number = $request->phone_number;
        $farmer->location = $request->location;
        $farmer->created_from = 'backend';
        $farmer->save();

        return redirect()->route('farmers.index')->with('success', 'Farmer created successfully.');
    }

    /**
     * Show the form for editing the specified farmer.
     */
    public function edit($id)
    {
        $farmer = Farmer::findOrFail($id);
        return view('farmers.edit', compact('farmer'));
    }

    /**
     * Update the specified farmer in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'location' => 'required|string|max:255',
            'created_from' => 'nullable|in:mobile_app,backend',
        ]);

        $farmer = Farmer::findOrFail($id);
        $farmer->name = $request->name;
        $farmer->phone_number = $request->phone_number;
        $farmer->location = $request->location;
        $farmer->created_from = 'backend';
        $farmer->save();

        return redirect()->route('farmers.index')->with('success', 'Farmer updated successfully.');
    }

    /**
     * Display the specified farmer with their loans and inputs.
     */
    public function show($id)
    {
        $farmer = Farmer::findOrFail($id);
        return view('farmers.show', compact('farmer'));
    }

    /**
     * Remove the specified farmer from storage.
     */
    public function destroy($id)
    {
        $farmer = Farmer::findOrFail($id);
        $farmer->delete();

        return redirect()->route('farmers.index')->with('success', 'Farmer deleted successfully.');
    }
}
