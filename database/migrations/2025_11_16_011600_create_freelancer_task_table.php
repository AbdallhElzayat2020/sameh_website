<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelancer_task', function (Blueprint $table) {
            $table->string('freelancer_code');
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->unique(['freelancer_code', 'task_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancer_task');
    }
};
