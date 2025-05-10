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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade')->name('booking_room_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->name('booking_user_id');
            $table->string('guest_name');
            $table->string('guest_phone');
            $table->string('guest_email')->nullable();
            $table->string('guest_address')->nullable();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('extra_pax')->default(0);
            $table->string('special_requests')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
