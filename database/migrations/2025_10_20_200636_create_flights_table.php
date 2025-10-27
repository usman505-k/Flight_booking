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
   Schema::create('flights', function (Blueprint $table) {
    $table->id();
    $table->string('flight_number');
    $table->string('origin');
    $table->string('destination');
    $table->date('departure_date');
    $table->time('departure_time');
    $table->integer('price');
    $table->integer('seats');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
