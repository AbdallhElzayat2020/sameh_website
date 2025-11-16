<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('client_po', function (Blueprint $table) {
            $table->id();
            $table->string('task_code');
            $table->string('client_code');
            $table->date('date_20');
            $table->date('date_80');
            $table->decimal('payment_20', 10, 2);
            $table->decimal('payment_80', 10, 2);
            $table->decimal('total_peice', 10, 2);
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_po');
    }
};
