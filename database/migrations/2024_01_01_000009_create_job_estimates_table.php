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
        Schema::create('job_estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('worker_id')->constrained();
            $table->integer('estimated_days')->comment('Worker estimated days');
            $table->integer('estimated_hours')->nullable()->comment('Additional hours');
            $table->decimal('labor_cost', 12, 2)->comment('Base labor cost');
            $table->decimal('bpjs_health', 12, 2)->comment('BPJS Kesehatan contribution');
            $table->decimal('bpjs_employment', 12, 2)->comment('BPJS Ketenagakerjaan contribution');
            $table->decimal('app_commission', 12, 2)->comment('Application commission');
            $table->decimal('total_cost', 12, 2)->comment('Total estimated cost');
            $table->dateTime('estimated_start_date');
            $table->dateTime('estimated_completion_date');
            $table->text('notes')->nullable()->comment('Estimate notes');
            $table->enum('status', ['pending', 'approved', 'rejected', 'revised'])->default('pending');
            $table->dateTime('expires_at')->comment('Estimate expiration date');
            $table->timestamps();
            
            $table->index(['job_request_id', 'status']);
            $table->index(['worker_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_estimates');
    }
};