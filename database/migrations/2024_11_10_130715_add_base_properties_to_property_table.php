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
        $properties = [
            'Centrala termica proprie',
            'Tamplarie PVC cu geam termopan',
            'Usa metalica',
            'Geam la baie',
            'Izolatie exterioara',
            'Aer conditionat',
        ];

        foreach ($properties as $property) {
            \App\Models\Property::query()->create([
                'name' => $property
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
