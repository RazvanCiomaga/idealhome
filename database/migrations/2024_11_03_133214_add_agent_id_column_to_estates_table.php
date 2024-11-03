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
        Schema::table('estates', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Agent::class, 'agent_id')->nullable();
            $table->foreignIdFor(\App\Models\Agency::class, 'agency_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn('agent_id');

            $table->dropForeign(['agency_id']);
            $table->dropColumn('agency_id');
        });
    }
};
