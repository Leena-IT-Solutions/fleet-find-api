<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use Illuminate\Support\Facades\Route;

// Public auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/profile/password', [AuthController::class, 'changePassword']);
    Route::delete('/profile/delete', [AuthController::class, 'deleteAccount']);
    Route::get('/organization', [AuthController::class, 'organization']);
    Route::get('/organizations/search', [AuthController::class, 'searchOrganizations']);
    Route::get('/children', [AuthController::class, 'getChildren']);
    Route::post('/children', [AuthController::class, 'addChild']);
    Route::put('/children/{id}', [AuthController::class, 'updateChild']);
    Route::delete('/children/{id}', [AuthController::class, 'deleteChild']);
    Route::get('/children/{id}', [AuthController::class, 'getChild']);
    Route::post('/children/{id}/relationships', [AuthController::class, 'addChildRelationship']);
    Route::delete('/children/{id}/relationships/{userId}', [AuthController::class, 'removeChildRelationship']);

    // Groups
    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::get('/groups/{id}', [GroupController::class, 'show']);
    Route::put('/groups/{id}', [GroupController::class, 'update']);
    Route::delete('/groups/{id}', [GroupController::class, 'destroy']);
    Route::post('/groups/{id}/members', [GroupController::class, 'addMember']);
    Route::delete('/groups/{id}/members/{userId}', [GroupController::class, 'removeMember']);
    Route::patch('/groups/{id}/members/{userId}/role', [GroupController::class, 'updateMemberRole']);
    Route::patch('/groups/{id}/location-sharing', [GroupController::class, 'toggleGroupLocationSharing']);

    // Location
    Route::patch('/location', [GroupController::class, 'updateLocation']);
    Route::get('/settings/location-interval', [GroupController::class, 'getLocationInterval']);

    // Subscriptions
    Route::get('/subscription-plans/{id}/enrollment-options', [AuthController::class, 'getSubscriptionEnrollmentOptions']);
    Route::post('/subscription-plans/{id}/enroll', [AuthController::class, 'enrollSubscription']);
});
