<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the groups the user belongs to.
     */
    public function index()
    {
        $user = Auth::user();
        $groups = $user->groups()->withCount('members')->get();

        return response()->json([
            'success' => true,
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created group.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $user->id,
        ]);

        // Attach creator as admin
        $group->members()->attach($user->id, [
            'role' => 'admin',
            'joined_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Group created successfully.',
            'group' => $group->load('members')
        ], 201);
    }

    /**
     * Display the specified group detail + members with locations.
     */
    public function show($id)
    {
        $user = Auth::user();
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.'
            ], 404);
        }

        if (!$group->isMember($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a member of this group.'
            ], 403);
        }

        // Return members with location info only if they have sharing enabled
        $members = $group->members()->get()->map(function ($member) {
            $isSharing = (bool) $member->location_sharing_enabled;
            return [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'mobile' => $member->mobile,
                'profile_photo' => $member->profile_photo,
                'role' => $member->pivot->role,
                'joined_at' => $member->pivot->joined_at,
                'location_sharing_enabled' => $isSharing,
                'latitude' => $isSharing ? (float) $member->latitude : null,
                'longitude' => $isSharing ? (float) $member->longitude : null,
                'location_updated_at' => $isSharing ? $member->location_updated_at : null,
            ];
        });

        // Determine if current user is admin
        $isAdmin = $group->isAdmin($user);

        return response()->json([
            'success' => true,
            'group' => [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'created_by' => $group->created_by,
                'created_at' => $group->created_at,
                'is_admin' => $isAdmin,
            ],
            'members' => $members
        ]);
    }

    /**
     * Update the specified group.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.'
            ], 404);
        }

        if (!$group->isAdmin($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Only group admins can update group details.'
            ], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group->update($request->only(['name', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Group updated successfully.',
            'group' => $group
        ]);
    }

    /**
     * Remove the specified group from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.'
            ], 404);
        }

        if (!$group->isAdmin($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Only group admins can delete groups.'
            ], 403);
        }

        $group->delete();

        return response()->json([
            'success' => true,
            'message' => 'Group deleted successfully.'
        ]);
    }

    /**
     * Add a member by email or mobile.
     */
    public function addMember(Request $request, $id)
    {
        $user = Auth::user();
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.'
            ], 404);
        }

        if (!$group->isAdmin($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Only group admins can add members.'
            ], 403);
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $search = trim($request->search);

        // Find user by email or mobile
        $newMember = User::where('email', $search)
            ->orWhere('mobile', $search)
            ->first();

        if (!$newMember) {
            return response()->json([
                'success' => false,
                'message' => 'User not found. Ensure the email or mobile number is registered.'
            ], 404);
        }

        // Check if already in group
        if ($group->isMember($newMember)) {
            return response()->json([
                'success' => false,
                'message' => 'User is already a member of this group.'
            ], 422);
        }

        $group->members()->attach($newMember->id, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member added successfully.',
            'member' => [
                'id' => $newMember->id,
                'name' => $newMember->name,
                'email' => $newMember->email,
                'mobile' => $newMember->mobile,
                'profile_photo' => $newMember->profile_photo,
                'role' => 'member',
            ]
        ]);
    }

    /**
     * Remove a member (or self-leave).
     */
    public function removeMember($id, $userId)
    {
        $user = Auth::user();
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.'
            ], 404);
        }

        $isSelf = $user->id == $userId;

        // Check permission: must be admin, or self leaving
        if (!$group->isAdmin($user) && !$isSelf) {
            return response()->json([
                'success' => false,
                'message' => 'Only group admins can remove members.'
            ], 403);
        }

        // Prevent removing the group creator (creator can only leave if they choose to)
        if ($group->created_by == $userId && !$isSelf) {
            return response()->json([
                'success' => false,
                'message' => 'Group creator cannot be removed by other admins.'
            ], 403);
        }

        // Enforce that we cannot leave/remove if this is the last admin
        if ($group->isAdmin(User::find($userId))) {
            $adminCount = $group->admins()->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot remove the last admin. Promote another member first.'
                ], 422);
            }
        }

        if (!$group->isMember(User::find($userId))) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a member of this group.'
            ], 422);
        }

        $group->members()->detach($userId);

        return response()->json([
            'success' => true,
            'message' => $isSelf ? 'You left the group.' : 'Member removed successfully.'
        ]);
    }

    /**
     * Promote or demote a member.
     */
    public function updateMemberRole(Request $request, $id, $userId)
    {
        $user = Auth::user();
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.'
            ], 404);
        }

        if (!$group->isAdmin($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Only group admins can change member roles.'
            ], 403);
        }

        $request->validate([
            'role' => 'required|in:admin,member',
        ]);

        $targetUser = User::find($userId);

        if (!$targetUser || !$group->isMember($targetUser)) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a member of this group.'
            ], 422);
        }

        // If demoting an admin, make sure they are not the last admin
        if ($request->role === 'member' && $group->isAdmin($targetUser)) {
            $adminCount = $group->admins()->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot demote the last admin. Promote another member first.'
                ], 422);
            }
        }

        $group->members()->updateExistingPivot($userId, [
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member role updated successfully.'
        ]);
    }

    /**
     * Update current user's location and sharing toggle status.
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'location_sharing_enabled' => 'required|boolean',
        ]);

        $user = Auth::user();

        $updateData = [
            'location_sharing_enabled' => $request->location_sharing_enabled,
        ];

        if ($request->location_sharing_enabled) {
            $updateData['latitude'] = $request->latitude;
            $updateData['longitude'] = $request->longitude;
            $updateData['location_updated_at'] = now();
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully.',
            'user' => [
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'location_sharing_enabled' => $user->location_sharing_enabled,
                'location_updated_at' => $user->location_updated_at,
            ]
        ]);
    }

    /**
     * Get the location update interval setting.
     */
    public function getLocationInterval()
    {
        $interval = Setting::get('location_update_interval_seconds', '10');

        return response()->json([
            'success' => true,
            'location_update_interval_seconds' => (int) $interval
        ]);
    }
}
