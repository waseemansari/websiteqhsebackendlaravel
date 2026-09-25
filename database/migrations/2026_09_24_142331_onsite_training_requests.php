<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onsite_training_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('type')->default('individual');
            $table->string('branch_id')->default('usa');
            $table->string('contact_name');
            $table->string('work_email');
            $table->string('phone');
            $table->string('facility_address')->nullable();
            $table->string('city');
            $table->string('state', 255);
            $table->string('zip_code', 20);
            $table->text('training_needs')->nullable();
            $table->text('training_topic')->nullable();
            $table->text('delivery_preference')->nullable();
            $table->unsignedInteger('number_of_participants');
            $table->text('equipment_conditions')->nullable();
            $table->text('preferred_dates')->nullable();
            $table->text('additional_details')->nullable();
            $table->enum('status', ['new', 'contacted', 'completed', 'cancelled'])->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onsite_training_requests');
    }
};