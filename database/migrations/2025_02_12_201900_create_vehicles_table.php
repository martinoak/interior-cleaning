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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('productionYear');
            $table->string('vin')->unique();
            $table->string('spz');
            $table->string('driver')->nullable();
            $table->string('color');
            $table->date('stk')->nullable();
            $table->date('tachograph')->nullable();
            $table->date('oilChange')->nullable();
            $table->date('insurance')->nullable();
            $table->string('vtp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
