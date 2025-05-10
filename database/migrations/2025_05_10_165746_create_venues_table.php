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
        Schema::create('venues', function (Blueprint $table) {
            $table->id('venue_id');
            $table->foreignId(('user_id'))->constrained('users')->onDelete('cascade')->name('venue_user_id');
            $table->foreignId('option_category_id')->constrained('option_categories')->onDelete('cascade')->name('room_option_category_id');
            $table->string('name');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->time('visitor_time_limit')->nullable();  
            $table->decimal('additional_overnight_price_per_pax', 10, 2)->nullable();
            $table->enum('status', ['available', 'maintenance'])->default('available');
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
