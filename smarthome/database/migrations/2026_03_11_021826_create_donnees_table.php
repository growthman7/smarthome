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
        Schema::create('donnees', function (Blueprint $table) {
            $table->id();
            $table->string('type'); //temperature, gaz, lumiere, humidite, volet
            $table->string('valeur');
            // $table->double('Gaz', 10, 2);
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donnees');
    }
};
