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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_registers_id')
                ->nullable()
                ->constrained('course_registers')
                ->nullOnDelete();
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();
            $table->string('stripe_session_id')
                ->nullable()
                ->unique();
            $table->string('stripe_payment_intent_id')
                ->nullable();
            $table->string('stripe_customer_id')
                ->nullable();
            $table->string('payment_method_id')
                ->nullable();
            $table->string('card_brand')
                ->nullable();
            $table->string('card_last4')
                ->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)
                ->default('usd');
            $table->string('status')
                ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
