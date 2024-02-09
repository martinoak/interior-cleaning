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
        Schema::create('vin', function (Blueprint $table) {
            $table->string('vin', 20)->primary();
            $table->string('name', 50);
            $table->string('manufacturer', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('engine', 50)->nullable();
            $table->string('year', 50)->nullable();
            $table->text('note')->nullable();
            $table->boolean('parsed')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vin');
    }
};
