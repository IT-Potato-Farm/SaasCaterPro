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
        Schema::table('orders', function (Blueprint $table) {
            // Alter the columns to store individual start and end times
            $table->dropColumn('event_start_time');
            $table->dropColumn('event_start_end');
            $table->time('event_start_time')->nullable()->after('event_date_start'); // to store start time
            $table->time('event_start_end')->nullable()->after('event_start_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('event_start_time');
            $table->dropColumn('event_start_end');
            $table->string('event_start_time')->nullable()->after('event_date_start'); 
            $table->string('event_start_end')->nullable()->after('event_start_time');  
        });
    }
};
