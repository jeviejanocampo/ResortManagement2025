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
            $table->id('payment_id');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade')->name('payment_booking_id');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'online_payment']);
            $table->string('reference_number')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->decimal('change', 10, 2)->nullable();
            $table->string('payment_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
