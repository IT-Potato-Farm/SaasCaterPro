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
        // ETO NA UNG ITEMS 
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Chicken, Beef
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('item_options', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g., "Fried", "Buttered"
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // pivot linking sa item option into items fried belongs to chicken etc
        Schema::create('item_item_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('item_option_id')->constrained('item_options')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['item_id', 'item_option_id']);
        });

        //pivot linking ng items sa package
        Schema::create('package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['package_id', 'item_id']);
        });

        // pivot table for linking specific option ex. sa package 1, ung chicken is Fried lng offered 
        Schema::create('package_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_item_id')->constrained('package_items')->onDelete('cascade');
            $table->foreignId('item_option_id')->constrained('item_options')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['package_item_id', 'item_option_id']);
        });


        // pivot for connecting utils table to package utils
        Schema::create('package_utilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->foreignId('utility_id')->constrained('utilities')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_utilities');
        Schema::dropIfExists('package_item_options');
        Schema::dropIfExists('package_items');
        Schema::dropIfExists('item_item_option');
        Schema::dropIfExists('item_options');
        Schema::dropIfExists('items');
    }
};
