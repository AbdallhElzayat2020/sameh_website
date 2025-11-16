<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('request_service', function (Blueprint $table) {
            $table->foreignId('project_request_id')->constrained('project_requests');
            $table->foreignId('service_id')->constrained('services');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_service');
    }
};
