<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Attendant;
use App\Models\User;
use Illuminate\Http\Request;

class CrewController extends Controller
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
            'identity' => 'required|string',
            'type' => 'required|in:driver,attendant',
        ]);

        $user = User::where('email', $request->identity)
            ->orWhere('mobile', $request->identity)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with that email or mobile number.'
            ], 422);
        }

        if ($request->type === 'driver') {
            $exists = Driver::where('user_id', $user->id)
                ->where('organization_id', $orgId)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This driver is already hired by this organization.'
                ], 422);
            }

            $crew = Driver::create([
                'user_id' => $user->id,
                'organization_id' => $orgId,
            ]);

            if (!$user->hasRole('Driver')) {
                $user->assignRole('Driver');
            }
        } else {
            $exists = Attendant::where('user_id', $user->id)
                ->where('organization_id', $orgId)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This attendant is already hired by this organization.'
                ], 422);
            }

            $crew = Attendant::create([
                'user_id' => $user->id,
                'organization_id' => $orgId,
            ]);

            if (!$user->hasRole('Attendant')) {
                $user->assignRole('Attendant');
            }
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst($request->type) . ' hired successfully.',
            'crew' => $crew
        ], 201);
    }

    public function destroy(Request $request, $orgId, $type, $id)
    {
        $organization = $request->user()->organizations()->where('organizations.id', $orgId)->first();
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or organization not found.'
            ], 403);
        }

        if ($type === 'driver') {
            $crew = Driver::where('organization_id', $orgId)->find($id);
            if (!$crew) {
                return response()->json([
                    'success' => false,
                    'message' => 'Driver not found.'
                ], 404);
            }
            $crew->delete();
        } elseif ($type === 'attendant') {
            $crew = Attendant::where('organization_id', $orgId)->find($id);
            if (!$crew) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendant not found.'
                ], 404);
            }
            $crew->delete();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid crew type.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Crew member removed successfully.'
        ]);
    }
}
