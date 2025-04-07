<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('home_page_content', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');  
            $table->string('title')->nullable();        
            $table->string('heading')->nullable();      
            $table->text('description')->nullable();   
            $table->string('image')->nullable();        
            $table->string('background_color')->nullable();        
            $table->string('text_color')->nullable();   
            $table->string('button_text_1_color')->nullable(); 
            $table->string('button_color_1')->nullable();   
            $table->string('button_text_2_color')->nullable(); 
            $table->string('button_color_2')->nullable();  
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('home_page_content');
    }
};
