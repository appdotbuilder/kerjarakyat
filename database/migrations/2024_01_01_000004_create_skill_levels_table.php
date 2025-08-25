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
        Schema::create('skill_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Skill level name (Beginner, Intermediate, Expert)');
            $table->decimal('hourly_rate_multiplier', 3, 2)->default(1.00)->comment('Multiplier for base hourly rate');
            $table->decimal('daily_rate_multiplier', 3, 2)->default(1.00)->comment('Multiplier for base daily rate');
            $table->decimal('overtime_rate_multiplier', 3, 2)->default(1.50)->comment('Multiplier for overtime rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_levels');
    }
};