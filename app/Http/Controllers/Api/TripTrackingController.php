<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TripRouteLogistics;
use App\Models\Driver;
use App\Models\Attendant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripTrackingController extends Controller
{
    /**
     * Helper to retrieve the TripRouteLogistics record and verify user permission.
     */
    private function getLogisticsWithPermission(int $tripId)
    {
        $user = Auth::user();
        
        // Find driver and attendant records associated with the user
        $driverIds = Driver::where('user_id', $user->id)->pluck('id')->toArray();
        $attendantIds = Attendant::where('user_id', $user->id)->pluck('id')->toArray();

        // Query the logistics record matching the trip ID AND assigned to the logged-in user
        $logistics = TripRouteLogistics::where('trip_id', $tripId)
            ->where(function ($query) use ($driverIds, $attendantIds) {
                $query->whereIn('driver_id', $driverIds)
                      ->orWhereIn('attendant_id', $attendantIds);
            })
            ->first();

        if (!$logistics) {
            $exists = TripRouteLogistics::where('trip_id', $tripId)->exists();
            return $exists ? false : null;
        }

        return $logistics;
    }

    /**
     * Toggle is_tracking flag on a trip.
     */
    public function toggleTracking(Request $request, $tripId)
    {
        $request->validate([
            'is_tracking' => 'required|boolean',
        ]);

        $logistics = $this->getLogisticsWithPermission((int) $tripId);

        if ($logistics === null) {
            return response()->json([
                'success' => false,
                'message' => 'Trip logistics not found.'
            ], 404);
        }

        if ($logistics === false) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned to this trip.'
            ], 403);
        }

        $isTracking = (bool) $request->is_tracking;
        $logistics->is_tracking = $isTracking;

        // If toggling off, clear coordinates and speed
        if (!$isTracking) {
            $logistics->latitude = null;
            $logistics->longitude = null;
            $logistics->speed = null;
        }

        $logistics->save();

        return response()->json([
            'success' => true,
            'is_tracking' => $logistics->is_tracking,
            'message' => $isTracking ? 'Live tracking enabled.' : 'Live tracking disabled and coordinates cleared.'
        ]);
    }

    /**
     * Update live location coordinates for a trip.
     */
    public function updateLocation(Request $request, $tripId)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0',
        ]);

        $logistics = $this->getLogisticsWithPermission((int) $tripId);

        if ($logistics === null) {
            return response()->json([
                'success' => false,
                'message' => 'Trip logistics not found.'
            ], 404);
        }

        if ($logistics === false) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned to this trip.'
            ], 403);
        }

        if (!$logistics->is_tracking) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking is not enabled for this trip.'
            ], 400);
        }

        $logistics->latitude = $request->latitude;
        $logistics->longitude = $request->longitude;
        if ($request->has('speed')) {
            $logistics->speed = $request->speed;
        }
        $logistics->touch();

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully.'
        ]);
    }
}
