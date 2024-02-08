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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('searchName');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();
            // $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('food_listing_id')->constrained('food_listings')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
