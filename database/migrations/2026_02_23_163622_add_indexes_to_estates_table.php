<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('estates', function (Blueprint $table) {
            // 1. Foreign Keys and Category Filters
            $table->index('estate_type_id');
            $table->index('offer_type');

            // 2. Location & Property Details (High frequency filters)
            $table->index('zone');
            $table->index('rooms');
            $table->index('floor');
            $table->index('room_entrances');

            // 3. Price & Year (Range filters)
            $table->index('sale_price');
            $table->index('rent_price');
            $table->index('construction_year');

            // 4. Combined Index (Example: Filtering by Zone and Rooms is very common)
            // This speeds up queries that use both filters simultaneously
            $table->index(['zone', 'rooms']);

            $table->index('crm_id');
        });
    }

    public function down()
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->dropIndex(['estate_type_id']);
            $table->dropIndex(['offer_type']);
            $table->dropIndex(['zone']);
            $table->dropIndex(['rooms']);
            $table->dropIndex(['floor']);
            $table->dropIndex(['room_entrances']);
            $table->dropIndex(['sale_price']);
            $table->dropIndex(['rent_price']);
            $table->dropIndex(['construction_year']);
            $table->dropIndex(['zone', 'rooms']);
            $table->dropIndex(['crm_id']);
        });
    }
};
