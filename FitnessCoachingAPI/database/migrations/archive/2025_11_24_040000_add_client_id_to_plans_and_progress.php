<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'meal_plans',
        'session_plans',
        'progress_trackers',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && ! Schema::hasColumn($tableName, 'client_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('client_id')->nullable()->after('id');
                });
            }
        }

        // For a fresh DB this is sufficient. If you need to backfill existing rows
        // based on coach relationships, write a separate non-destructive migration.
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
                });
                // Make column required now that FK exists and fresh DB won't have nulls
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('client_id')->nullable(false)->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'client_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['client_id']);
                    $table->dropColumn('client_id');
                });
            }
        }
    }
};
