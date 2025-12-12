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
        \DB::statement('
            UPDATE meal_plans mp
            INNER JOIN clients c ON c.coach_id = mp.coach_id
            SET mp.client_id = (
                SELECT c2.id FROM clients c2 
                WHERE c2.coach_id = mp.coach_id 
                ORDER BY c2.id ASC 
                LIMIT 1
            )
            WHERE mp.client_id IS NULL
        ');

        \DB::statement('
            UPDATE session_plans sp
            INNER JOIN clients c ON c.coach_id = sp.coach_id
            SET sp.client_id = (
                SELECT c2.id FROM clients c2 
                WHERE c2.coach_id = sp.coach_id 
                ORDER BY c2.id ASC 
                LIMIT 1
            )
            WHERE sp.client_id IS NULL
        ');

        \DB::statement('
            UPDATE progress_trackers pt
            INNER JOIN clients c ON c.coach_id = pt.coach_id
            SET pt.client_id = (
                SELECT c2.id FROM clients c2 
                WHERE c2.coach_id = pt.coach_id 
                ORDER BY c2.id ASC 
                LIMIT 1
            )
            WHERE pt.client_id IS NULL
        ');

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
        $foreignKeys = \DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'meal_plans' 
            AND CONSTRAINT_NAME = 'meal_plans_client_id_foreign'
        ", [$dbName]);
        
        if (empty($foreignKeys)) {
            Schema::table('meal_plans', function (Blueprint $table) {
                $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            });
        }
        
        Schema::table('meal_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
        });

        // Check and add foreign key for session_plans
        $foreignKeys = \DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'session_plans' 
            AND CONSTRAINT_NAME = 'session_plans_client_id_foreign'
        ", [$dbName]);
        
        if (empty($foreignKeys)) {
            Schema::table('session_plans', function (Blueprint $table) {
                $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            });
        }
        
        Schema::table('session_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
        });

        // Check and add foreign key for progress_trackers
        $foreignKeys = \DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'progress_trackers' 
            AND CONSTRAINT_NAME = 'progress_trackers_client_id_foreign'
        ", [$dbName]);
        
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
