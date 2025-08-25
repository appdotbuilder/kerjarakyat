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
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('nik')->nullable()->unique()->after('address')->comment('Identity card number');
            $table->decimal('latitude', 10, 8)->nullable()->after('nik')->comment('GPS latitude');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude')->comment('GPS longitude');
            $table->foreignId('city_id')->nullable()->constrained();
            $table->enum('role', ['user', 'worker', 'admin'])->default('user')->after('city_id');
            $table->boolean('is_active')->default(true)->after('role');
            
            $table->index(['role', 'is_active']);
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropIndex(['role', 'is_active']);
            $table->dropIndex(['latitude', 'longitude']);
            $table->dropColumn([
                'phone', 'address', 'nik', 'latitude', 'longitude', 
                'city_id', 'role', 'is_active'
            ]);
        });
    }
};