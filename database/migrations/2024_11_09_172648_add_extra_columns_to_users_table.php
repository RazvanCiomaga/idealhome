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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('imobmanager_id')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->string('picture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('imobmanager_id');
            $table->dropColumn('phone');
            $table->dropColumn('position');
            $table->dropColumn('description');
            $table->dropColumn('picture');
        });
    }
};
