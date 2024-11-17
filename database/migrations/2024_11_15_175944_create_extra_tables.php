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
        Schema::create('estate_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('imobmanager_id')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('offer_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('imobmanager_id')->unique()->nullable();
            $table->timestamps();
        });

        Schema::table('estates', function (Blueprint $table) {
            $table->unsignedBigInteger('estate_type_id')->nullable();
            $table->unsignedBigInteger('offer_type_id')->nullable();
            $table->json('estate_properties')->nullable();
            $table->string('facebook_url')->nullable();
            $table->boolean('home_page_display')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_types');
        Schema::dropIfExists('offer_types');
    }
};
