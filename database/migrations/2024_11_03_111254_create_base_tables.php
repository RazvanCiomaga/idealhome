<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Agencies table
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('imobmanager_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('cuifirma')->nullable();
            $table->string('jfirma')->nullable();
            $table->string('registry')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        // Estates table
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('imobmanager_id')->unique()->nullable();
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->string('city')->nullable();
            $table->string('zone')->nullable();
            $table->string('county')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('floor')->nullable();
            $table->string('max_floor')->nullable();
            $table->string('floor_formatted')->nullable();
            $table->integer('area')->nullable();
            $table->integer('usable_area')->nullable();
            $table->integer('total_area')->nullable();
            $table->integer('land_area')->nullable();
            $table->string('room_entrances')->nullable();
            $table->integer('offer_type')->nullable();
            $table->bigInteger('sale_price')->nullable();
            $table->bigInteger('rent_price')->nullable();
            $table->bigInteger('rent_price_sqm')->nullable();
            $table->year('construction_year')->nullable();
            $table->string('energy_class')->nullable();
            $table->string('general')->nullable();
            $table->boolean('exclusive')->default(false)->nullable();
            $table->bigInteger('comission')->default(false)->nullable();
            $table->string('thumb')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('images')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->dateTime('published_date')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });

        // Agents table
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('imobmanager_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
        Schema::dropIfExists('agents');
        Schema::dropIfExists('estates');
    }
};
