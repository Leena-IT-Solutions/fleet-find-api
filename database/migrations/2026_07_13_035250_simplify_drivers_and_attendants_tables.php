<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Simplify drivers table
        Schema::table('drivers', function (Blueprint $table) {
            // Drop foreign key constraints first to avoid MySQL index errors
            $table->dropForeign(['user_id']);
            $table->dropForeign(['organization_id']);
            
            // Drop unique constraint on user_id
            $table->dropUnique('drivers_user_id_unique');
            
            // Drop personal details and document columns
            $table->dropColumn([
                'name',
                'number',
                'email',
                'address',
                'license',
                'aadhar_photo',
                'license_photo'
            ]);
            
            // Make user_id and organization_id non-nullable
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreignId('organization_id')->nullable(false)->change();
            
            // Re-establish foreign keys with cascade on delete
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            
            // Add composite unique index to act as pivot table
            $table->unique(['user_id', 'organization_id'], 'drivers_user_org_unique');
        });

        // 2. Simplify attendants table
        Schema::table('attendants', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['user_id']);
            $table->dropForeign(['organization_id']);
            
            // Drop unique constraint on user_id
            $table->dropUnique('attendants_user_id_unique');
            
            // Drop personal details and document columns
            $table->dropColumn([
                'name',
                'number',
                'email',
                'address',
                'aadhar_photo'
            ]);
            
            // Make user_id and organization_id non-nullable
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreignId('organization_id')->nullable(false)->change();
            
            // Re-establish foreign keys with cascade on delete
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            
            // Add composite unique index to act as pivot table
            $table->unique(['user_id', 'organization_id'], 'attendants_user_org_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropUnique('drivers_user_org_unique');
            $table->dropForeign(['user_id']);
            $table->dropForeign(['organization_id']);
            
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('organization_id')->nullable()->change();
            
            $table->unique('user_id', 'drivers_user_id_unique');
            
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('organization_id')->references('id')->on('organizations')->nullOnDelete();
            
            $table->string('name')->after('organization_id');
            $table->string('number')->nullable()->after('name');
            $table->string('email')->nullable()->after('number');
            $table->text('address')->nullable()->after('email');
            $table->string('license')->nullable()->after('address');
            $table->string('aadhar_photo')->nullable()->after('license');
            $table->string('license_photo')->nullable()->after('aadhar_photo');
        });

        Schema::table('attendants', function (Blueprint $table) {
            $table->dropUnique('attendants_user_org_unique');
            $table->dropForeign(['user_id']);
            $table->dropForeign(['organization_id']);
            
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('organization_id')->nullable()->change();
            
            $table->unique('user_id', 'attendants_user_id_unique');
            
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('organization_id')->references('id')->on('organizations')->nullOnDelete();
            
            $table->string('name')->after('organization_id');
            $table->string('number')->nullable()->after('name');
            $table->string('email')->nullable()->after('number');
            $table->text('address')->nullable()->after('email');
            $table->string('aadhar_photo')->nullable()->after('address');
        });
    }
};
