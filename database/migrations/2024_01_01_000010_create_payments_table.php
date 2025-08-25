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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('worker_id')->constrained();
            $table->decimal('amount', 12, 2)->comment('Payment amount');
            $table->enum('type', ['advance', 'final', 'overtime', 'bonus'])->comment('Payment type');
            $table->enum('method', ['in_app_wallet', 'bank_transfer', 'cash'])->comment('Payment method');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('reference_number')->nullable()->comment('Payment gateway reference');
            $table->text('notes')->nullable()->comment('Payment notes/reason');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            
            $table->index(['job_request_id', 'type']);
            $table->index(['status', 'method']);
            $table->index(['user_id', 'worker_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};