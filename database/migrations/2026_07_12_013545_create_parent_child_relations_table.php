<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('relationship_type')->nullable(); // Mother, Father, Guardian, Other
            $table->foreignId('co_parent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('pending_co_parent_link')->nullable();
        });

        // 2. Create child_user pivot table
        Schema::create('child_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->string('relationship_type'); // Mother, Father, Guardian, Other
            $table->timestamps();

            $table->unique(['user_id', 'child_id']);
        });

        // 3. Migrate existing data from children.parent_id
        $children = DB::table('children')->select('id', 'parent_id')->get();
        foreach ($children as $child) {
            $user = DB::table('users')->where('id', $child->parent_id)->first();
            $relation = 'Other';
            if ($user && !empty($user->relationship_type)) {
                $relation = $user->relationship_type;
            }
            DB::table('child_user')->insert([
                'user_id' => $child->parent_id,
                'child_id' => $child->id,
                'relationship_type' => $relation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Drop the parent_id column from children table (except SQLite during tests)
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('children', function (Blueprint $table) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Restore parent_id column on children table
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('children', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_id')->nullable();
            });
        }

        // 2. Restore data from child_user pivot
        $relations = DB::table('child_user')->select('user_id', 'child_id')->get();
        foreach ($relations as $relation) {
            DB::table('children')->where('id', $relation->child_id)->update([
                'parent_id' => $relation->user_id,
            ]);
        }

        // Add foreign key constraint back
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('children', function (Blueprint $table) {
                $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 3. Drop tables and columns
        Schema::dropIfExists('child_user');

        Schema::table('users', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['co_parent_id']);
            }
            $table->dropColumn(['relationship_type', 'co_parent_id', 'pending_co_parent_link']);
        });
    }
};
