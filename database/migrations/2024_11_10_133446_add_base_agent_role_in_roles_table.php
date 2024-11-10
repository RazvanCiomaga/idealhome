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
        $role = \Spatie\Permission\Models\Role::query()->where('name', 'agent')->first();

        if (!$role) {
            \Spatie\Permission\Models\Role::query()->create([
                'name' => 'agent'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
