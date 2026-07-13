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
            ->get(['drivers.id', 'users.name as driver_name']);

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
        $perPage = $request->input('per_page', 20);

        $paginator = \App\Models\Organization::query()
            ->with('subscriptionPlans')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('address', 'like', '%' . $query . '%')
                  ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'organizations' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
                'has_more' => $paginator->hasMorePages(),
            ]
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
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'photo' => ['nullable', 'string'], // base64 representation
            'relationship_type' => ['nullable', 'string', 'in:Mother,Father,Guardian,Other'],
        ]);

        $user = $request->user();
        $child = new \App\Models\Child();
        $child->name = $request->name;
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
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'photo' => ['nullable', 'string'], // base64 representation or path
            'relationship_type' => ['nullable', 'string', 'in:Mother,Father,Guardian,Other'],
        ]);

        $child->name = $request->name;
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
        $roles = $user->roles()->pluck('name')->toArray();
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'profile_photo' => $user->profile_photo ? url($user->profile_photo) : null,
            'roles' => empty($roles) ? ['Parent'] : $roles,
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

    public function getSubscriptionEnrollmentOptions(Request $request, $id)
    {
        $user = $request->user();
        $plan = \App\Models\SubscriptionPlan::with(['organization', 'routes.stops'])->find($id);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription plan not found.'
            ], 404);
        }

        // Get organization
        $organization = $plan->organization;

        // Children of the parent user
        $children = $user->children()->get()->map(function ($child) {
            return [
                'id' => $child->id,
                'name' => $child->name,
                'gender' => $child->gender,
                'photo' => $child->photo ? url($child->photo) : null,
            ];
        });

        // Grades and Divisions of the organization
        $grades = \App\Models\Grade::where('organization_id', $organization->id)
            ->with('divisions')
            ->get()
            ->map(function ($grade) {
                return [
                    'id' => $grade->id,
                    'name' => $grade->name,
                    'divisions' => $grade->divisions->map(function ($division) {
                        return [
                            'id' => $division->id,
                            'name' => $division->name,
                        ];
                    }),
                ];
            });

        // Routes and Stops of the subscription plan
        $routes = $plan->routes->map(function ($route) {
            return [
                'id' => $route->id,
                'name' => $route->name,
                'description' => $route->description,
                'stops' => $route->stops->map(function ($stop) {
                    return [
                        'id' => $stop->id,
                        'name' => $stop->name,
                        'latitude' => $stop->latitude,
                        'longitude' => $stop->longitude,
                    ];
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'children' => $children,
            'grades' => $grades,
            'routes' => $routes,
        ]);
    }

    public function enrollSubscription(Request $request, $id)
    {
        $user = $request->user();
        $plan = \App\Models\SubscriptionPlan::find($id);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription plan not found.'
            ], 404);
        }

        // Validate registration window
        $today = now()->startOfDay();
        $start = \Illuminate\Support\Carbon::parse($plan->registration_start_date)->startOfDay();
        $end = \Illuminate\Support\Carbon::parse($plan->registration_end_date)->endOfDay();

        if ($today->lt($start)) {
            return response()->json([
                'success' => false,
                'message' => 'Registration has not started yet.'
            ], 422);
        }

        if ($today->gt($end)) {
            return response()->json([
                'success' => false,
                'message' => 'Registration is closed.'
            ], 422);
        }

        // Validation of request fields
        $request->validate([
            'child_id' => ['required', 'exists:children,id'],
            'grade_id' => ['required', 'exists:grades,id'],
            'division_id' => ['required', 'exists:divisions,id'],
            'route_id' => ['required', 'exists:routes,id'],
            'pickup_stop_id' => ['required', 'exists:stops,id'],
            'drop_stop_id' => ['required', 'exists:stops,id'],
        ]);

        // Further validations to ensure data integrity:
        // 1. Verify child belongs to this parent
        $child = $user->children()->find($request->child_id);
        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid child selected.'
            ], 422);
        }

        // 2. Prevent duplicate active/pending subscription of the same child to the same plan
        $existing = \App\Models\ChildSubscription::where('child_id', $request->child_id)
            ->where('subscription_plan_id', $plan->id)
            ->exists();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'This child is already enrolled or has a pending enrollment in this plan.'
            ], 422);
        }

        // 3. Verify grade belongs to the organization
        $grade = \App\Models\Grade::where('id', $request->grade_id)
            ->where('organization_id', $plan->organization_id)
            ->first();
        if (!$grade) {
            return response()->json([
                'success' => false,
                'message' => 'Selected grade does not belong to this organization.'
            ], 422);
        }

        // 4. Verify division belongs to the selected grade
        $division = \App\Models\Division::where('id', $request->division_id)
            ->where('grade_id', $grade->id)
            ->first();
        if (!$division) {
            return response()->json([
                'success' => false,
                'message' => 'Selected division does not belong to the selected grade.'
            ], 422);
        }

        // 5. Verify route belongs to the subscription plan
        $routeLink = $plan->routes()->where('routes.id', $request->route_id)->exists();
        if (!$routeLink) {
            return response()->json([
                'success' => false,
                'message' => 'Selected route is not available for this subscription plan.'
            ], 422);
        }

        // 6. Verify stops belong to the selected route
        $pickupStop = \App\Models\Stop::where('id', $request->pickup_stop_id)
            ->where('route_id', $request->route_id)
            ->first();
        $dropStop = \App\Models\Stop::where('id', $request->drop_stop_id)
            ->where('route_id', $request->route_id)
            ->first();

        if (!$pickupStop || !$dropStop) {
            return response()->json([
                'success' => false,
                'message' => 'Selected stops do not belong to the selected route.'
            ], 422);
        }

        // Store subscription
        $subscription = \App\Models\ChildSubscription::create([
            'child_id' => $request->child_id,
            'subscription_plan_id' => $plan->id,
            'grade_id' => $request->grade_id,
            'division_id' => $request->division_id,
            'route_id' => $request->route_id,
            'pickup_stop_id' => $request->pickup_stop_id,
            'drop_stop_id' => $request->drop_stop_id,
            'parent_id' => $user->id,
            'status' => 'pending', // Pending approval / payment confirmation
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription request submitted successfully.',
            'subscription' => $subscription,
        ]);
    }

    public function getDriverTrips(Request $request)
    {
        $user = $request->user();
        
        $driverIds = \App\Models\Driver::where('user_id', $user->id)->pluck('id')->toArray();

        $logistics = \App\Models\TripRouteLogistics::whereIn('driver_id', $driverIds)
            ->with([
                'trip.tripStops.stop',
                'trip.organization',
                'vehicle',
                'attendant.user'
            ])
            ->get();

        $trips = $logistics->map(function ($logistic) use ($user) {
            $trip = $logistic->trip;
            $routeId = $logistic->route_id;
            
            $divisionIds = $trip->divisions()->pluck('divisions.id')->toArray();
            $subscriptionsQuery = \App\Models\ChildSubscription::where('route_id', $routeId)
                ->whereIn('status', ['active', 'pending', 'hold']);

            if (!empty($divisionIds)) {
                $subscriptionsQuery->whereIn('division_id', $divisionIds);
            }
            $subscriptions = $subscriptionsQuery->with(['child.parents', 'grade', 'division'])->get();

            $stops = $trip->tripStops
                ->filter(function ($ts) use ($routeId) {
                    return $ts->stop && $ts->stop->route_id == $routeId;
                })
                ->map(function ($ts) use ($subscriptions) {
                    $stopId = $ts->stop_id;
                    $stopChildren = $subscriptions->filter(function ($sub) use ($stopId) {
                        return $sub->pickup_stop_id == $stopId || $sub->drop_stop_id == $stopId;
                    })->map(function ($sub) use ($stopId) {
                        $parent = $sub->child->parents->first();
                        return [
                            'id' => $sub->child->id,
                            'name' => $sub->child->name,
                            'status' => $sub->status,
                            'grade' => $sub->grade->name ?? 'N/A',
                            'division' => $sub->division->name ?? 'N/A',
                            'is_pickup' => $sub->pickup_stop_id == $stopId,
                            'is_drop' => $sub->drop_stop_id == $stopId,
                            'parent_name' => $parent->name ?? 'N/A',
                            'parent_phone' => $parent->mobile ?? '',
                        ];
                    })->values()->all();

                    return [
                        'id' => $ts->id,
                        'stop_id' => $ts->stop_id,
                        'name' => $ts->stop->name ?? 'Unknown Stop',
                        'time' => $ts->time,
                        'sequence_order' => $ts->stop->sequence_order ?? 0,
                        'children' => $stopChildren,
                    ];
                })->sortBy('time')->values()->all();

            return [
                'id' => $trip->id,
                'name' => $trip->name,
                'organization' => $trip->organization->name ?? 'Unknown Organization',
                'vehicle' => $logistic->vehicle ? [
                    'id' => $logistic->vehicle->id,
                    'registration_number' => $logistic->vehicle->registration_number,
                    'model' => $logistic->vehicle->model,
                    'type' => $logistic->vehicle->type,
                ] : null,
                'driver' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                ],
                'assistant' => $logistic->attendant ? [
                    'id' => $logistic->attendant->id,
                    'name' => $logistic->attendant->name,
                    'mobile' => $logistic->attendant->number,
                ] : null,
                'stops' => $stops,
                'is_tracking' => $logistic->is_tracking,
            ];
        });

        return response()->json([
            'success' => true,
            'driver' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'profile_photo' => $user->profile_photo ? url($user->profile_photo) : null,
            ],
            'trips' => $trips,
        ]);
    }

    public function getAttendantTrips(Request $request)
    {
        $user = $request->user();
        
        $attendantIds = \App\Models\Attendant::where('user_id', $user->id)->pluck('id')->toArray();

        $logistics = \App\Models\TripRouteLogistics::whereIn('attendant_id', $attendantIds)
            ->with([
                'trip.tripStops.stop',
                'trip.organization',
                'vehicle',
                'driver.user'
            ])
            ->get();

        $trips = $logistics->map(function ($logistic) use ($user) {
            $trip = $logistic->trip;
            $routeId = $logistic->route_id;
            
            $divisionIds = $trip->divisions()->pluck('divisions.id')->toArray();
            $subscriptionsQuery = \App\Models\ChildSubscription::where('route_id', $routeId)
                ->whereIn('status', ['active', 'pending', 'hold']);

            if (!empty($divisionIds)) {
                $subscriptionsQuery->whereIn('division_id', $divisionIds);
            }
            $subscriptions = $subscriptionsQuery->with(['child.parents', 'grade', 'division'])->get();

            $stops = $trip->tripStops
                ->filter(function ($ts) use ($routeId) {
                    return $ts->stop && $ts->stop->route_id == $routeId;
                })
                ->map(function ($ts) use ($subscriptions) {
                    $stopId = $ts->stop_id;
                    $stopChildren = $subscriptions->filter(function ($sub) use ($stopId) {
                        return $sub->pickup_stop_id == $stopId || $sub->drop_stop_id == $stopId;
                    })->map(function ($sub) use ($stopId) {
                        $parent = $sub->child->parents->first();
                        return [
                            'id' => $sub->child->id,
                            'name' => $sub->child->name,
                            'status' => $sub->status,
                            'grade' => $sub->grade->name ?? 'N/A',
                            'division' => $sub->division->name ?? 'N/A',
                            'is_pickup' => $sub->pickup_stop_id == $stopId,
                            'is_drop' => $sub->drop_stop_id == $stopId,
                            'parent_name' => $parent->name ?? 'N/A',
                            'parent_phone' => $parent->mobile ?? '',
                        ];
                    })->values()->all();

                    return [
                        'id' => $ts->id,
                        'stop_id' => $ts->stop_id,
                        'name' => $ts->stop->name ?? 'Unknown Stop',
                        'time' => $ts->time,
                        'sequence_order' => $ts->stop->sequence_order ?? 0,
                        'children' => $stopChildren,
                    ];
                })->sortBy('time')->values()->all();

            return [
                'id' => $trip->id,
                'name' => $trip->name,
                'organization' => $trip->organization->name ?? 'Unknown Organization',
                'vehicle' => $logistic->vehicle ? [
                    'id' => $logistic->vehicle->id,
                    'registration_number' => $logistic->vehicle->registration_number,
                    'model' => $logistic->vehicle->model,
                    'type' => $logistic->vehicle->type,
                ] : null,
                'driver' => $logistic->driver ? [
                    'id' => $logistic->driver->id,
                    'name' => $logistic->driver->name,
                    'mobile' => $logistic->driver->number,
                ] : null,
                'assistant' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                ],
                'stops' => $stops,
                'is_tracking' => $logistic->is_tracking,
            ];
        });

        return response()->json([
            'success' => true,
            'attendant' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'profile_photo' => $user->profile_photo ? url($user->profile_photo) : null,
            ],
            'trips' => $trips,
        ]);
    }

    public function getChildTracking(Request $request, $id)
    {
        $user = $request->user();
        $child = $user->children()->find($id);

        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found or you do not have permission to view this child.'
            ], 404);
        }

        // Get child active subscription
        $subscription = \App\Models\ChildSubscription::where('child_id', $child->id)
            ->with(['pickupStop', 'dropStop'])
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'This child is not currently enrolled in any route.'
            ]);
        }

        // Find the trip associated with this route
        $logistics = \App\Models\TripRouteLogistics::where('route_id', $subscription->route_id)
            ->orderBy('is_tracking', 'desc')
            ->orderBy('updated_at', 'desc')
            ->first();
        if (!$logistics) {
            return response()->json([
                'success' => false,
                'message' => 'No active trip found for this child\'s route.'
            ]);
        }

        $trip = \App\Models\Trip::find($logistics->trip_id);
        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip configuration not found.'
            ]);
        }

        // Fetch stops ordered by stops.sequence_order
        $stops = $trip->tripStops()
            ->join('stops', 'trip_stops.stop_id', '=', 'stops.id')
            ->where('stops.route_id', $subscription->route_id)
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

        // Retrieve organization for school location
        $organization = $trip->organization;
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
                $stops[] = $schoolStop; // school at last
            } else {
                array_unshift($stops, $schoolStop); // school at first
            }
        }

        // Determine if actively tracking
        $isTracking = (bool) $logistics->is_tracking;
        if ($isTracking && $logistics->updated_at) {
            // Check threshold (3x interval)
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
            'child_name' => $child->name,
            'trip_id' => $trip->id,
            'trip_name' => $trip->name,
            'is_tracking' => $isTracking,
            'latitude' => $isTracking ? (double) $logistics->latitude : null,
            'longitude' => $isTracking ? (double) $logistics->longitude : null,
            'speed' => $isTracking ? (double) $logistics->speed : null,
            'updated_at' => $isTracking && $logistics->updated_at ? $logistics->updated_at->timezone('Asia/Kolkata')->toIso8601String() : null,
            'pickup_stop' => $subscription->pickupStop ? [
                'id' => $subscription->pickupStop->id,
                'name' => $subscription->pickupStop->name,
                'latitude' => (double) $subscription->pickupStop->latitude,
                'longitude' => (double) $subscription->pickupStop->longitude,
            ] : null,
            'drop_stop' => $subscription->dropStop ? [
                'id' => $subscription->dropStop->id,
                'name' => $subscription->dropStop->name,
                'latitude' => (double) $subscription->dropStop->latitude,
                'longitude' => (double) $subscription->dropStop->longitude,
            ] : null,
            'stops' => $stops,
            'stops_order' => $logistics->stops_order ?: 'asc',
            'map_provider' => $mapProvider,
            'mapbox_access_token' => $mapboxAccessToken,
            'google_maps_api_key' => $googleMapsApiKey,
        ]);
    }
}
