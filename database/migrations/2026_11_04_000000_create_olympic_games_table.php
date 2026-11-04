<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('olympic_games', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->unsignedSmallInteger('year');
            $table->string('card_type');
            $table->string('card_text');
            $table->string('full_title');
            $table->string('image_path')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('stadium');
            $table->unsignedSmallInteger('countries_count');
            $table->unsignedInteger('athletes_count');
            $table->string('sports');            // например: 28 (301 комплект)
            $table->string('medal_winner');
            $table->json('facts')->nullable();
            $table->string('header_theme');      // athens, beijing, london, rio, tokyo
            $table->softDeletes();               // Soft Deletes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('olympic_games');
    }
};
