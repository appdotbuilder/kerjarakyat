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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('City name');
            $table->string('province')->comment('Province name');
            $table->decimal('minimum_wage', 12, 2)->comment('UMK - Regional minimum wage');
            $table->timestamps();
            
            $table->index('name');
            $table->index('province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};