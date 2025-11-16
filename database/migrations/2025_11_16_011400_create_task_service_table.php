<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_service', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained();
            $table->foreignId('task_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_service');
    }
};
