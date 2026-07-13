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

    public function getRouteTracking(Request $request, $orgId, $routeId)
    {
        $organization = $request->user()->organizations()->where('organizations.id', $orgId)->first();
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or organization not found.'
            ], 403);
        }

        $logistics = TripRouteLogistics::where('route_id', $routeId)
            ->first();

        if (!$logistics) {
            return response()->json([
                'success' => false,
                'message' => 'No logistics found for this route.'
            ], 404);
        }

        $trip = Trip::find($logistics->trip_id);
        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip not found.'
            ], 404);
        }

        // Fetch stops ordered by stops.sequence_order
        $stops = $trip->tripStops()
            ->join('stops', 'trip_stops.stop_id', '=', 'stops.id')
            ->where('stops.route_id', $routeId)
            ->select('stops.*', 'trip_stops.time')
            ->orderBy('stops.sequence_order', $logistics->stops_order ?: 'asc')
            ->get()
            ->map(function ($stop) {
                return [
                    'id' => $stop->id,
                    'name' => $stop->name,
                    'latitude' => (double) $stop->latitude,
                    'longitude' => (double) $stop->longitude,
                    'time' => $stop->time ? substr($stop->time, 0, 5) : null,
                    'is_school' => false,
                ];
            })
            ->toArray();

        if ($organization && $organization->latitude && $organization->longitude) {
            $schoolStop = [
                'id' => -1,
                'name' => $organization->name,
                'latitude' => (double) $organization->latitude,
                'longitude' => (double) $organization->longitude,
                'time' => null,
                'is_school' => true,
            ];

            $stopsOrder = $logistics->stops_order ?: 'asc';
            if ($stopsOrder === 'desc') {
                $stops[] = $schoolStop;
            } else {
                array_unshift($stops, $schoolStop);
            }
        }

        $isTracking = (bool) $logistics->is_tracking;
        if ($isTracking && $logistics->updated_at) {
            $interval = (int) \App\Models\Setting::get('location_update_interval_seconds', '10');
            $thresholdSeconds = max(30, $interval * 3);
            if ($logistics->updated_at->lt(now()->subSeconds($thresholdSeconds))) {
                $isTracking = false;
            }
        }

        $mapProvider = \App\Models\Setting::get('map_provider', 'leaflet');
        $mapboxAccessToken = \App\Models\Setting::get('mapbox_access_token', '');
        $googleMapsApiKey = \App\Models\Setting::get('google_maps_api_key', '');

        return response()->json([
            'success' => true,
            'trip_id' => $trip->id,
            'trip_name' => $trip->name,
            'is_tracking' => $isTracking,
            'latitude' => $isTracking ? (double) $logistics->latitude : null,
            'longitude' => $isTracking ? (double) $logistics->longitude : null,
            'speed' => $isTracking ? (double) $logistics->speed : null,
            'updated_at' => $isTracking && $logistics->updated_at ? $logistics->updated_at->timezone('Asia/Kolkata')->toIso8601String() : null,
            'stops' => $stops,
            'map_provider' => $mapProvider,
            'mapbox_access_token' => $mapboxAccessToken,
            'google_maps_api_key' => $googleMapsApiKey,
        ]);
    }
}
