<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industry_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('industry_id')->constrained('industries');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industry_options');
    }
};
