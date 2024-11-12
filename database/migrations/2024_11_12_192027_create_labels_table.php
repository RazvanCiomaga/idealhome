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
        Schema::create('labels', function (Blueprint $table) {
            $table->id();

            $table->longText('value');
            $table->longText('label');

            $table->timestamps();
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->id();

            $table->string('locale');
            $table->unsignedBigInteger('translatable_id');
            $table->longText('value');
            $table->string('translatable_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labels');
        Schema::dropIfExists('translations');
    }
};
