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
        Schema::create('venue_pricing_tiers', function (Blueprint $table) {
            $table->id('pricing_tier_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->name('pricing_tier_user_id');
            $table->foreignId('venue_id')->constrained('venues')->onDelete('cascade')->name('pricing_tier_venue_id');
            $table->integer('max_pax')->default(0);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('included_overnight_pax')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_pricing_tiers');
    }
};
