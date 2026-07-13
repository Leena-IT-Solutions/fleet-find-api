<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function store(Request $request, $orgId)
    {
        $organization = $request->user()->organizations()->where('organizations.id', $orgId)->first();
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or organization not found.'
            ], 403);
        }

        $request->validate([
            'registration_number' => 'required|string|unique:vehicles,registration_number',
            'type' => 'required|string|max:50',
        ]);

        $vehicle = $organization->vehicles()->create([
            'registration_number' => $request->registration_number,
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle created successfully.',
            'vehicle' => $vehicle
        ], 201);
    }

    public function update(Request $request, $orgId, $id)
    {
        $organization = $request->user()->organizations()->where('organizations.id', $orgId)->first();
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or organization not found.'
            ], 403);
        }

        $vehicle = $organization->vehicles()->find($id);
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found.'
            ], 404);
        }

        $request->validate([
            'registration_number' => 'required|string|unique:vehicles,registration_number,' . $id,
            'type' => 'required|string|max:50',
        ]);

        $vehicle->update([
            'registration_number' => $request->registration_number,
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully.',
            'vehicle' => $vehicle
        ]);
    }

    public function destroy(Request $request, $orgId, $id)
    {
        $organization = $request->user()->organizations()->where('organizations.id', $orgId)->first();
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or organization not found.'
            ], 403);
        }

        $vehicle = $organization->vehicles()->find($id);
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found.'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully.'
        ]);
    }
}
