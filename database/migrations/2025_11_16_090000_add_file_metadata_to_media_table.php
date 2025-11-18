<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            if (!Schema::hasColumn('media', 'path')) {
                $table->string('path')->after('type');
            }

            if (!Schema::hasColumn('media', 'original_name')) {
                $table->string('original_name')->after('path');
            }

            if (!Schema::hasColumn('media', 'mime_type')) {
                $table->string('mime_type')->after('original_name');
            }

            if (!Schema::hasColumn('media', 'size')) {
                $table->unsignedBigInteger('size')->after('mime_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            foreach (['path', 'original_name', 'mime_type', 'size'] as $column) {
                if (Schema::hasColumn('media', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
