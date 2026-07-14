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
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();

            // Subscriber status
            $table->enum('status', [
                'pending',
                'subscribed',
                'unsubscribed'
            ])->default('pending');

            // Email verification
            $table->string('verification_token')->nullable();
            $table->timestamp('verified_at')->nullable();

            // Unsubscribe
            $table->timestamp('unsubscribed_at')->nullable();

            // Optional fields
            $table->string('name')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('source')->nullable(); // website, footer, popup, etc.

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
};