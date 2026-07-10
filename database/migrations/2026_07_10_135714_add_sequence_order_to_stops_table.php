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
        Schema::table('stops', function (Blueprint $table) {
            $table->integer('sequence_order')->default(0)->after('longitude');
        });

        // Initialize sequence orders for existing stops to preserve current ordering
        $routes = DB::table('routes')->get();
        foreach ($routes as $route) {
            $stops = DB::table('stops')->where('route_id', $route->id)->orderBy('id')->get();
            $order = 1;
            foreach ($stops as $stop) {
                DB::table('stops')->where('id', $stop->id)->update(['sequence_order' => $order++]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stops', function (Blueprint $table) {
            $table->dropColumn('sequence_order');
        });
    }
};
