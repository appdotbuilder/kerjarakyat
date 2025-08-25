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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users');
            $table->foreignId('reviewee_id')->constrained('users');
            $table->integer('rating')->comment('Rating from 1-5');
            $table->text('comment')->nullable()->comment('Review comment');
            $table->enum('type', ['client_to_worker', 'worker_to_client'])->comment('Review type');
            $table->boolean('is_visible')->default(true)->comment('Review visibility');
            $table->timestamps();
            
            $table->index(['reviewee_id', 'type', 'is_visible']);
            $table->index(['job_request_id', 'type']);
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};