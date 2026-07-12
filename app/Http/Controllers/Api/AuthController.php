<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetPasswordOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $this->formatUserResponse($user),
            'roles' => ['Parent'],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $loginKey = $request->has('login') ? 'login' : 'email';

        $validator = Validator::make($request->all(), [
            $loginKey => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $loginValue = $request->input($loginKey);

        $user = User::where('email', $loginValue)
            ->orWhere('mobile', $loginValue)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid login credentials.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $roles = $user->roles()->pluck('name')->toArray();

        return response()->json([
            'user' => $this->formatUserResponse($user),
            'roles' => empty($roles) ? ['Parent'] : $roles,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'We could not find a user with that email address.'
            ], 404);
        }

        // Generate a 6-digit numeric OTP
        $otp = (string) mt_rand(100000, 999999);

        // Store OTP in database hashed
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($otp),
                'created_at' => now()
            ]
        );

        // Log the OTP for local development ease
        Log::info("Password reset OTP for {$request->email}: {$otp}");

        // Email the OTP code
        try {
            Mail::to($request->email)->send(new ResetPasswordOtpMail($otp));
        } catch (\Exception $e) {
            Log::error("Failed to email password reset OTP: " . $e->getMessage());
        }

        return response()->json([
            'message' => 'Verification code sent successfully to your email.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return response()->json([
                'message' => 'No active password reset request found for this email.'
            ], 422);
        }

        // Check expiration (60 minutes)
        if (now()->subMinutes(60)->gt($record->created_at)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return response()->json([
                'message' => 'The verification code has expired.'
            ], 422);
        }

        // Check if correct OTP
        if (!Hash::check($request->code, $record->token)) {
            return response()->json([
                'message' => 'Invalid verification code.'
            ], 422);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Delete reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Your password has been successfully reset.'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out.'
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $roles = $user->roles()->pluck('name')->toArray();

        return response()->json([
            'user' => $this->formatUserResponse($user),
            'roles' => empty($roles) ? ['Parent'] : $roles,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'mobile' => ['required', 'string', 'max:20', 'unique:users,mobile,' . $user->id],
            'profile_photo' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;

        $oldPhoto = $user->profile_photo;
        $updatedPhoto = false;

        if ($request->has('profile_photo') && !empty($request->profile_photo)) {
            $photoData = $request->profile_photo;
            
            // Check if it's base64 data URL
            if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
                $photoData = substr($photoData, strpos($photoData, ',') + 1);
                $type = strtolower($type[1]); // png, jpg, jpeg
                
                if (in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    $photoData = base64_decode($photoData);
                    if ($photoData !== false) {
                        $fileName = 'profile_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $type;
                        $path = public_path('profile_photos');
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        file_put_contents($path . '/' . $fileName, $photoData);
                        $user->profile_photo = 'profile_photos/' . $fileName;
                        $updatedPhoto = true;
                    }
                }
            } else if ($request->file('profile_photo')) {
                // Support normal file uploads
                $file = $request->file('profile_photo');
                $fileName = 'profile_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('profile_photos'), $fileName);
                $user->profile_photo = 'profile_photos/' . $fileName;
                $updatedPhoto = true;
            } else {
                // Direct relative path or raw string
                if (str_starts_with($photoData, 'profile_photos/')) {
                    $user->profile_photo = $photoData;
                    $updatedPhoto = true;
                } else if (filter_var($photoData, FILTER_VALIDATE_URL)) {
                    $user->profile_photo = $photoData;
                    $updatedPhoto = true;
                }
            }

            // Delete old photo if it was updated and was a local file
            if ($updatedPhoto && $oldPhoto && $oldPhoto !== $user->profile_photo && str_starts_with($oldPhoto, 'profile_photos/')) {
                $oldPath = public_path($oldPhoto);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $this->formatUserResponse($user)
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'The provided password does not match your current password.'
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully.'
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $user = $request->user();
        
        // Revoke tokens
        $user->tokens()->delete();
        
        // Delete profile photo if it exists locally
        $photo = $user->profile_photo;
        if ($photo && str_starts_with($photo, 'profile_photos/')) {
            $path = public_path($photo);
            if (file_exists($path) && is_file($path)) {
                @unlink($path);
            }
        }
        
        // Delete user
        $user->delete();

        return response()->json([
            'message' => 'Account deleted successfully.'
        ]);
    }

    public function organization(Request $request)
    {
        $user = $request->user();
        $orgId = $request->query('organization_id');

        if ($orgId) {
            $organization = $user->organizations()->where('organizations.id', $orgId)->first();
        } else {
            $organization = $user->organizations()->first();
        }

        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'User is not associated with this organization.'
            ], 404);
        }

        // Load counts
        $organization->loadCount(['vehicles', 'drivers', 'attendants', 'routes', 'trips']);

        // Load vehicles list
        $vehicles = $organization->vehicles()->get(['id', 'registration_number', 'type']);

        // Load drivers with their user names
        $drivers = $organization->drivers()
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->get(['drivers.id', 'users.name as driver_name', 'drivers.license']);

        // Load attendants with their user names
        $attendants = $organization->attendants()
            ->join('users', 'attendants.user_id', '=', 'users.id')
            ->get(['attendants.id', 'users.name as attendant_name']);

        // Get all organizations of this user
        $allOrganizations = $user->organizations()->get(['organizations.id', 'organizations.name']);

        return response()->json([
            'success' => true,
            'organization' => [
                'id' => $organization->id,
                'name' => $organization->name,
                'contact_name' => $organization->contact_name,
                'number' => $organization->number,
                'email' => $organization->email,
                'address' => $organization->address,
                'logo' => $organization->logo ? url($organization->logo) : null,
                'vehicles_count' => $organization->vehicles_count,
                'drivers_count' => $organization->drivers_count,
                'attendants_count' => $organization->attendants_count,
                'routes_count' => $organization->routes_count,
                'trips_count' => $organization->trips_count,
                'vehicles' => $vehicles,
                'drivers' => $drivers,
                'attendants' => $attendants,
            ],
            'organizations' => $allOrganizations
        ]);
    }

    public function searchOrganizations(\Illuminate\Http\Request $request)
    {
        $query = $request->input('q', '');

        $organizations = \App\Models\Organization::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('address', 'like', '%' . $query . '%')
                  ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'organizations' => $organizations
        ]);
    }

    public function getChildren(Request $request)
    {
        $user = $request->user();
        $children = $user->children()->orderBy('id', 'desc')->get();

        // Format photo URL if present
        $children = $children->map(function ($child) {
            return [
                'id' => $child->id,
                'parent_id' => $child->parent_id,
                'name' => $child->name,
                'dob' => $child->dob,
                'gender' => $child->gender,
                'photo' => $child->photo ? url($child->photo) : null,
                'relationship_type' => $child->pivot?->relationship_type ?: 'Parent',
            ];
        });

        return response()->json([
            'success' => true,
            'children' => $children
        ]);
    }

    public function addChild(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'photo' => ['nullable', 'string'], // base64 representation
            'relationship_type' => ['nullable', 'string', 'in:Mother,Father,Guardian,Other'],
        ]);

        $user = $request->user();
        $child = new \App\Models\Child();
        $child->name = $request->name;
        $child->dob = $request->dob;
        $child->gender = $request->gender;

        if (\Illuminate\Support\Facades\Schema::hasColumn('children', 'parent_id')) {
            $child->parent_id = $user->id;
        }

        if ($request->has('photo') && !empty($request->photo)) {
            $photoData = $request->photo;
            
            // Check if it's base64 data URL
            if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
                $photoData = substr($photoData, strpos($photoData, ',') + 1);
                $type = strtolower($type[1]); // png, jpg, jpeg
                
                if (in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    $photoData = base64_decode($photoData);
                    if ($photoData !== false) {
                        $fileName = 'child_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $type;
                        $path = public_path('child_photos');
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        file_put_contents($path . '/' . $fileName, $photoData);
                        $child->photo = 'child_photos/' . $fileName;
                    }
                }
            }
        }

        $child->save();

        // Attach relationship to current user safely
        $relationship = $request->relationship_type ?: 'Other';
        $user->children()->syncWithoutDetaching([$child->id => ['relationship_type' => $relationship]]);

        return response()->json([
            'success' => true,
            'message' => 'Child added successfully.',
            'child' => [
                'id' => $child->id,
                'parent_id' => $child->parent_id,
                'name' => $child->name,
                'dob' => $child->dob,
                'gender' => $child->gender,
                'photo' => $child->photo ? url($child->photo) : null,
                'relationship_type' => $relationship,
            ]
        ]);
    }

    public function updateChild(Request $request, $id)
    {
        $user = $request->user();
        $child = $user->children()->find($id);

        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found.'
            ], 404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'photo' => ['nullable', 'string'], // base64 representation or path
            'relationship_type' => ['nullable', 'string', 'in:Mother,Father,Guardian,Other'],
        ]);

        $child->name = $request->name;
        $child->dob = $request->dob;
        $child->gender = $request->gender;

        if ($request->has('photo') && !empty($request->photo)) {
            $photoData = $request->photo;
            
            // Check if it's base64 data URL
            if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
                $photoData = substr($photoData, strpos($photoData, ',') + 1);
                $type = strtolower($type[1]); // png, jpg, jpeg
                
                if (in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    $photoData = base64_decode($photoData);
                    if ($photoData !== false) {
                        // Delete old child photo if exists
                        if ($child->photo && str_starts_with($child->photo, 'child_photos/')) {
                            $oldPath = public_path($child->photo);
                            if (file_exists($oldPath) && is_file($oldPath)) {
                                @unlink($oldPath);
                            }
                        }

                        $fileName = 'child_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $type;
                        $path = public_path('child_photos');
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        file_put_contents($path . '/' . $fileName, $photoData);
                        $child->photo = 'child_photos/' . $fileName;
                    }
                }
            } else {
                if (str_starts_with($photoData, 'child_photos/')) {
                    $child->photo = $photoData;
                }
            }
        }

        $child->save();

        if ($request->has('relationship_type')) {
            $user->children()->updateExistingPivot($child->id, ['relationship_type' => $request->relationship_type]);
        }

        $relationship = $user->children()->find($child->id)?->pivot?->relationship_type ?: 'Other';

        return response()->json([
            'success' => true,
            'message' => 'Child updated successfully.',
            'child' => [
                'id' => $child->id,
                'parent_id' => $child->parent_id,
                'name' => $child->name,
                'dob' => $child->dob,
                'gender' => $child->gender,
                'photo' => $child->photo ? url($child->photo) : null,
                'relationship_type' => $relationship,
            ]
        ]);
    }

    public function deleteChild(Request $request, $id)
    {
        $user = $request->user();
        $child = $user->children()->find($id);

        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found.'
            ], 404);
        }

        // Delete photo if exists
        if ($child->photo && str_starts_with($child->photo, 'child_photos/')) {
            $oldPath = public_path($child->photo);
            if (file_exists($oldPath) && is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $child->delete();

        return response()->json([
            'success' => true,
            'message' => 'Child deleted successfully.'
        ]);
    }

    private function formatUserResponse(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'profile_photo' => $user->profile_photo ? url($user->profile_photo) : null,
        ];
    }

    public function getChild(Request $request, $id)
    {
        $user = $request->user();
        $child = $user->children()->find($id);

        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found or you do not have permission to view this child.'
            ], 404);
        }

        // Load all linked parents with pivot data
        $relationships = $child->parents()->get()->map(function ($parent) {
            return [
                'id' => $parent->id,
                'name' => $parent->name,
                'email' => $parent->email,
                'mobile' => $parent->mobile,
                'relationship_type' => $parent->pivot?->relationship_type ?: 'Other',
            ];
        });

        return response()->json([
            'success' => true,
            'child' => [
                'id' => $child->id,
                'name' => $child->name,
                'dob' => $child->dob,
                'gender' => $child->gender,
                'photo' => $child->photo ? url($child->photo) : null,
                'relationships' => $relationships,
            ]
        ]);
    }

    public function addChildRelationship(Request $request, $id)
    {
        $user = $request->user();
        $child = $user->children()->find($id);

        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found or you do not have permission to modify this child.'
            ], 404);
        }

        $request->validate([
            'email_or_mobile' => ['required', 'string'],
            'relationship_type' => ['required', 'string', 'in:Mother,Father,Guardian,Other'],
        ]);

        $input = $request->email_or_mobile;

        // Search for user by email or mobile
        $foundUser = User::where('email', $input)
            ->orWhere('mobile', $input)
            ->first();

        if (!$foundUser) {
            return response()->json([
                'success' => false,
                'message' => 'We could not find a registered parent with that email address or mobile number.'
            ], 404);
        }

        // Attach user to child with relationship type
        $child->parents()->syncWithoutDetaching([
            $foundUser->id => ['relationship_type' => $request->relationship_type]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Relationship added successfully.'
        ]);
    }

    public function removeChildRelationship(Request $request, $id, $userId)
    {
        $user = $request->user();
        $child = $user->children()->find($id);

        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found or you do not have permission to modify this child.'
            ], 404);
        }

        // Prevent unlinking the last parent to avoid orphan children profiles
        if ($child->parents()->count() <= 1 && $child->parents()->where('users.id', $userId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'A child profile must have at least one linked parent or guardian.'
            ], 422);
        }

        $child->parents()->detach($userId);

        return response()->json([
            'success' => true,
            'message' => 'Relationship removed successfully.'
        ]);
    }
}
