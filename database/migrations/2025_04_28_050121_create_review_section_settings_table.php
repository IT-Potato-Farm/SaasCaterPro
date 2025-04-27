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
        Schema::create('review_section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('What Our Customers Say');
            $table->json('featured_reviews')->nullable(); // 👈
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_section_settings');
    }
};
