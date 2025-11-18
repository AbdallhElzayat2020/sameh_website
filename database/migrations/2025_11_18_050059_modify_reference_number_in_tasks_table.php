<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the old string column
            $table->dropColumn('reference_number');
        });

        Schema::table('tasks', function (Blueprint $table) {
            // Add new foreign key column
            $table->foreignId('reference_number')->nullable()->after('task_number')->constrained('tasks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['reference_number']);
            $table->dropColumn('reference_number');
        });

        Schema::table('tasks', function (Blueprint $table) {
            // Restore old string column
            $table->string('reference_number')->nullable()->after('task_number');
        });
    }
};
