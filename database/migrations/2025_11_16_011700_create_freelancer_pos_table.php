<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelancer_pos', function (Blueprint $table) {
            $table->id();
            $table->string('freelancer_code');
            $table->string('task_code');
            $table->string('project_name');
            $table->string('page_number');
            $table->decimal('price', 10);
            $table->date('start_date');
            $table->date('payment_date');
            $table->longText('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancer_pos');
    }
};
