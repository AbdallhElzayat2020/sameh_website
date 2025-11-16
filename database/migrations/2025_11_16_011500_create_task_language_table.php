<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_language', function (Blueprint $table) {
            $table->string('language_src');
            $table->integer('language_target');
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_language');
    }
};
