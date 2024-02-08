<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 255);
            $table->string('email', 255);
            $table->string('telephone', 20);
            $table->text('message')->nullable();
            $table->string('variant', 255)->nullable();
            $table->string('hasTerm', 10)->nullable();
            $table->boolean('feedbackSent')->default(false);
            $table->boolean('isArchived')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
