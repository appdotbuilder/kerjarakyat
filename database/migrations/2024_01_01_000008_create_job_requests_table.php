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
        Schema::create('job_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('worker_id')->nullable()->constrained();
            $table->foreignId('skill_category_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->string('title')->comment('Job title');
            $table->text('description')->comment('Job description');
            $table->text('location_address')->comment('Detailed job address');
            $table->decimal('location_latitude', 10, 8)->nullable();
            $table->decimal('location_longitude', 11, 8)->nullable();
            $table->dateTime('preferred_start_date')->comment('Client preferred start date');
            $table->integer('estimated_duration_days')->comment('Estimated duration in days');
            $table->integer('estimated_duration_hours')->nullable()->comment('Estimated duration in hours if less than a day');
            $table->enum('urgency', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['open', 'survey_requested', 'survey_scheduled', 'estimated', 'approved', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->decimal('estimated_cost', 12, 2)->nullable()->comment('Worker estimated cost');
            $table->decimal('final_cost', 12, 2)->nullable()->comment('Final agreed cost');
            $table->dateTime('actual_start_date')->nullable();
            $table->dateTime('actual_end_date')->nullable();
            $table->text('client_notes')->nullable();
            $table->text('worker_notes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'city_id']);
            $table->index(['user_id', 'status']);
            $table->index(['worker_id', 'status']);
            $table->index(['skill_category_id', 'city_id']);
            $table->index(['location_latitude', 'location_longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_requests');
    }
};