<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('freelancer_po_service', function (Blueprint $table) {
            $table->foreignId('freelancer_po_id')->constrained('freelancer_po')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->unique(['freelancer_po_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancer_po_service');
    }
};
