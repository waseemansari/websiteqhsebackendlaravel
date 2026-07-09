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
        Schema::create('feed_backs', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('course');
            $table->string('trainer');
            $table->string('other_specify')->nullable();
            $table->text('enjoy')->nullable();
            $table->text('profession')->nullable();
            $table->text('comments')->nullable();
            $table->text('enroll')->nullable();
            $table->text('branch_id')->nullable();
            $table->enum('status',['new','readed'])->default('new');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_backs');
    }
};
