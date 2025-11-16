<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('project_name');
            $table->longText('description');
            $table->string('time_zone');
            $table->date('start_date');
            $table->time('start_date_time');
            $table->date('end_date');
            $table->time('end_date_time');
            $table->string('preferred_payment_type');
            $table->string('source_language');
            $table->string('target_language');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->string('currency');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_requests');
    }
};
