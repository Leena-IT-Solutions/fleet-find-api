<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\TripRouteLogistics;
use Illuminate\Http\Request;

class TripLogisticsController extends Controller
{
    public function assign(Request $request, $orgId, $tripId)
    {
        $organization = $request->user()->organizations()->where('organizations.id', $orgId)->first();
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or organization not found.'
            ], 403);
        }

        $trip = $organization->trips()->find($tripId);
        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip not found.'
            ], 404);
        }

        $request->validate([
            'route_id' => 'required|integer|exists:routes,id',
            'vehicle_id' => 'nullable|integer|exists:vehicles,id',
            'driver_id' => 'nullable|integer|exists:drivers,id',
            'attendant_id' => 'nullable|integer|exists:attendants,id',
        ]);

        $logistics = TripRouteLogistics::updateOrCreate(
            ['trip_id' => $tripId, 'route_id' => $request->route_id],
            [
                'vehicle_id' => $request->vehicle_id,
                'driver_id' => $request->driver_id,
                'attendant_id' => $request->attendant_id,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Trip logistics assigned successfully.',
            'logistics' => $logistics
        ]);
    }
}
