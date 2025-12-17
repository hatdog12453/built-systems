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
        // Check if client_id column exists, if not add it
        if (!Schema::hasColumn('meal_plans', 'client_id')) {
            Schema::table('meal_plans', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('session_plans', 'client_id')) {
            Schema::table('session_plans', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('progress_trackers', 'client_id')) {
            Schema::table('progress_trackers', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id')->nullable()->after('id');
            });
        }

        // Update existing records: set client_id based on coach_id
        // For each record, find the first client with matching coach_id
        \DB::statement('\n            UPDATE meal_plans mp\n            INNER JOIN clients c ON c.coach_id = mp.coach_id\n            SET mp.client_id = (\n                SELECT c2.id FROM clients c2 \n                WHERE c2.coach_id = mp.coach_id \n                ORDER BY c2.id ASC \n                LIMIT 1\n            )\n            WHERE mp.client_id IS NULL\n        ');

        \DB::statement('\n            UPDATE session_plans sp\n            INNER JOIN clients c ON c.coach_id = sp.coach_id\n            SET sp.client_id = (\n                SELECT c2.id FROM clients c2 \n                WHERE c2.coach_id = sp.coach_id \n                ORDER BY c2.id ASC \n                LIMIT 1\n            )\n            WHERE sp.client_id IS NULL\n        ');

        \DB::statement('\n            UPDATE progress_trackers pt\n            INNER JOIN clients c ON c.coach_id = pt.coach_id\n            SET pt.client_id = (\n                SELECT c2.id FROM clients c2 \n                WHERE c2.coach_id = pt.coach_id \n                ORDER BY c2.id ASC \n                LIMIT 1\n            )\n            WHERE pt.client_id IS NULL\n        ');

        // Delete any records that couldn't be matched (orphaned records)
        \DB::table('meal_plans')->whereNull('client_id')->delete();
        \DB::table('session_plans')->whereNull('client_id')->delete();
        \DB::table('progress_trackers')->whereNull('client_id')->delete();

        // Delete any records with invalid client_id (not existing in clients table)
        \DB::table('meal_plans')
            ->whereNotIn('client_id', function($query) {
                $query->select('id')->from('clients');
            })
            ->delete();

        \DB::table('session_plans')
            ->whereNotIn('client_id', function($query) {
                $query->select('id')->from('clients');
            })
            ->delete();

        \DB::table('progress_trackers')
            ->whereNotIn('client_id', function($query) {
                $query->select('id')->from('clients');
            })
            ->delete();

        // Now add foreign key constraints if they don't exist, and make client_id required
        $connection = Schema::getConnection();
        $dbName = $connection->getDatabaseName();
        
        // Check and add foreign key for meal_plans
        $foreignKeys = \DB::select("\n            SELECT CONSTRAINT_NAME \n            FROM information_schema.KEY_COLUMN_USAGE \n            WHERE TABLE_SCHEMA = ? \n            AND TABLE_NAME = 'meal_plans' \n            AND CONSTRAINT_NAME = 'meal_plans_client_id_foreign'\n        ", [$dbName]);
        
        if (empty($foreignKeys)) {
            Schema::table('meal_plans', function (Blueprint $table) {
                $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            });
        }
        
        Schema::table('meal_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
        });

        // Check and add foreign key for session_plans
        $foreignKeys = \DB::select("\n            SELECT CONSTRAINT_NAME \n            FROM information_schema.KEY_COLUMN_USAGE \n            WHERE TABLE_SCHEMA = ? \n            AND TABLE_NAME = 'session_plans' \n            AND CONSTRAINT_NAME = 'session_plans_client_id_foreign'\n        ", [$dbName]);
        
        if (empty($foreignKeys)) {
            Schema::table('session_plans', function (Blueprint $table) {
                $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            });
        }
        
        Schema::table('session_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
        });

        // Check and add foreign key for progress_trackers
        $foreignKeys = \DB::select("\n            SELECT CONSTRAINT_NAME \n            FROM information_schema.KEY_COLUMN_USAGE \n            WHERE TABLE_SCHEMA = ? \n            AND TABLE_NAME = 'progress_trackers' \n            AND CONSTRAINT_NAME = 'progress_trackers_client_id_foreign'\n        ", [$dbName]);
        
        if (empty($foreignKeys)) {
            Schema::table('progress_trackers', function (Blueprint $table) {
                $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            });
        }
        
        Schema::table('progress_trackers', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meal_plans', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::table('session_plans', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::table('progress_trackers', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
