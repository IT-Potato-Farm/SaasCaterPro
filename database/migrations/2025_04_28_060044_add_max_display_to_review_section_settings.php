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
        Schema::table('review_section_settings', function (Blueprint $table) {
            $table->integer('max_display')->default(5); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_section_settings', function (Blueprint $table) {
            $table->dropColumn('max_display');
        });
    }
};
