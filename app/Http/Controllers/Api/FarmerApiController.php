<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Exception;

class FarmerApiController extends Controller
{
    public function index()
    {
        try {
            return response()->json(Farmer::latest()->get(), 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error fetching farmers.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:15|unique:farmers',
                'location' => 'required|string|max:255',
            ]);

            $farmer = Farmer::create([
                ...$validated,
                'created_from' => 'mobile_app'
            ]);

            return response()->json([
                'message' => 'Farmer created successfully.',
                'farmer' => $farmer
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating farmer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:15|unique:farmers,phone_number,' . $id,
                'location' => 'required|string|max:255',
            ]);

            $farmer = Farmer::findOrFail($id);
            $farmer->update([
                ...$validated,
                'created_from' => 'mobile_app'
            ]);

            return response()->json([
                'message' => 'Farmer updated successfully.',
                'farmer' => $farmer
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error updating farmer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $farmer = Farmer::findOrFail($id);

            // Check for related data before deletion
            if ($farmer->farmerLoans()->exists()) {
                return response()->json([
                    'message' => 'Cannot delete farmer with existing loans.'
                ], 400);
            }

            $farmer->delete();

            return response()->json([
                'message' => 'Farmer deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting farmer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
