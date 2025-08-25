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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_category_id')->constrained();
            $table->foreignId('skill_level_id')->constrained();
            $table->string('certification_number')->nullable()->comment('Certification number from BLK');
            $table->date('certification_date')->nullable()->comment('Date of certification');
            $table->date('certification_expiry')->nullable()->comment('Certification expiry date');
            $table->enum('certification_status', ['pending', 'scheduled', 'certified', 'expired'])->default('pending');
            $table->text('bio')->nullable()->comment('Worker bio/description');
            $table->decimal('rating', 3, 2)->default(0.00)->comment('Average rating');
            $table->integer('total_jobs')->default(0)->comment('Total completed jobs');
            $table->integer('total_reviews')->default(0)->comment('Total reviews received');
            $table->boolean('is_available')->default(true)->comment('Worker availability status');
            $table->timestamps();
            
            $table->index(['skill_category_id', 'skill_level_id']);
            $table->index(['certification_status', 'is_available']);
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};