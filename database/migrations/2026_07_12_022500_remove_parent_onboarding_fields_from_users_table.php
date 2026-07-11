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
        if (\Illuminate\Support\Facades\DB::getDriverName() !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['co_parent_id']);
                $table->dropColumn(['relationship_type', 'co_parent_id', 'pending_co_parent_link']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('relationship_type')->nullable();
            $table->foreignId('co_parent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('pending_co_parent_link')->nullable();
        });
    }
};
