<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelancer_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('freelancer_po_id')->constrained();
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancer_invoices');
    }
};
