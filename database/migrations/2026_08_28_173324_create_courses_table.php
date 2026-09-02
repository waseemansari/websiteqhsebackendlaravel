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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('branch_id');
            $table->decimal('price', 10, 2);
            $table->string('photo')->nullable();
            $table->string('duration')->nullable();
            $table->string('mode')->nullable();
            $table->string('desc')->nullable();
            $table->string('currency')->nullable(); 
            $table->enum('status',['new','active','inactive'])->default('new');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
