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
        Schema::rename('customers', 'old_customers');
        Schema::rename('feedbacks', 'old_feedbacks');
        Schema::rename('invoices', 'old_invoices');
        Schema::rename('vouchers', 'old_vouchers');


        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('telephone', 15)->nullable();
            $table->text('message')->nullable();
            $table->string('variant', 255)->nullable();
            $table->dateTime('term')->nullable();
            $table->boolean('feedbackSent')->default(false);
            $table->boolean('archived')->default(false);
        });

//        Schema::create('calendar', function (Blueprint $table) {
//            $table->id();
//            $table->dateTime('date');
//            $table->boolean('done')->default(false);
//        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->string('hash', 255)->primary();
            $table->string('name', 255);
            $table->text('message')->nullable();
            $table->integer('rating');
            $table->boolean('fromGoogle')->default(false);
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->char('type', 1);
            $table->dateTime('date');
            $table->string('name', 255);
            $table->unsignedInteger('price');
            $table->char('worker', 1);
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('hash', 10)->primary();
            $table->dateTime('date');
            $table->unsignedInteger('price');
            $table->boolean('accepted')->default(false);
        });

        Schema::table('customers', function (Blueprint $table) {
//            $table->unsignedBigInteger('calendar_id')->nullable();
//            $table->foreign('calendar_id')->references('id')->on('calendar');
            $table->string('feedback_hash')->nullable();
            $table->foreign('feedback_hash')->references('hash')->on('feedbacks');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
        });


//        Schema::table('calendar', function (Blueprint $table) {
//            $table->unsignedBigInteger('invoice_id')->nullable();
//            $table->foreign('invoice_id')->references('id')->on('invoices');
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('vouchers');
        Schema::rename('old_customers', 'customers');
        Schema::rename('old_feedbacks', 'feedbacks');
        Schema::rename('old_invoices', 'invoices');
        Schema::rename('old_vouchers', 'vouchers');
    }
};
