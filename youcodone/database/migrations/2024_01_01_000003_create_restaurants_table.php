<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cuisine_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('localisation');
            $table->integer('capacite');
            $table->dateTime('ouverture_a')->nullable();
            $table->timestamps();
            
            $table->index(['localisation', 'cuisine_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};