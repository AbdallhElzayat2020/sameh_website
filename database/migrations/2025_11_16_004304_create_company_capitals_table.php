<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_capitals', function (Blueprint $table) {
            $table->id();
$table->string('total_capital_egp');
$table->string('total_capital_usd');
$table->string('temporary_capital_egp');
$table->string('temporary_capital_usd');
$table->string('emergency_capital_egp');
$table->string('emergency_capital_usd');
$table->timestamps();//
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_capitals');
    }
};
