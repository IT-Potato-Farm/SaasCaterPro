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
        Schema::create('package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->string('name'); // fill if chicken, beef, etc.
            
            $table->text('description')->nullable();
            // $table->primary(['package_id', 'menu_item_id']);
            $table->timestamps(); 
            $table->unique(['package_id', 'name']);
        });

        Schema::create('package_food_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_food_item_id')->constrained('package_items')->onDelete('cascade');
            $table->string('type'); // e.g., "Fried", "Buttered"
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            
            $table->timestamps();
        });

        Schema::create('package_utilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->string('name')->unique(); // e.g., "Table", "Chair"
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_utilities');
        Schema::dropIfExists('package_food_item_options');
        Schema::dropIfExists('package_items');
    }
};
