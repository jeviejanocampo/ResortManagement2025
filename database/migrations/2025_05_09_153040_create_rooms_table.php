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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('room_id');
            $table->string('room_number', 50)->unique();
            $table->string('room_type', 50)->index();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->name('room_user_id');
            $table->foreignId('option_category_id')->constrained('option_categories')->onDelete('cascade')->name('room_option_category_id');
            $table->integer('pax')->default(1);
            $table->decimal('rate_per_night', 8, 2)->default(0.00);
            $table->time('checked_in')->nullable();
            $table->time('checked_out')->nullable();
            $table->enum('status', ['available', 'maintenance'])->default('available');
            $table->string('description', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
