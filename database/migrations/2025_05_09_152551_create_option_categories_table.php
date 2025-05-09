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
        Schema::create('option_categories', function (Blueprint $table) {
            $table->id('option_category_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->name('option_categories_user_id');
            $table->string('name', 100)->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_categories');
    }
};
