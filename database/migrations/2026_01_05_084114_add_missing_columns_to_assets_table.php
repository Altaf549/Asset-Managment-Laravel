<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if 'type' column exists and rename it to 'asset_type'
        if (Schema::hasColumn('assets', 'type') && !Schema::hasColumn('assets', 'asset_type')) {
            if (DB::getDriverName() === 'sqlite') {
                DB::statement('ALTER TABLE assets RENAME COLUMN type TO asset_type');
            } else {
                // For MySQL
                DB::statement('ALTER TABLE assets CHANGE type asset_type VARCHAR(255)');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename asset_type back to type (only if asset_type exists and type doesn't)
        if (Schema::hasColumn('assets', 'asset_type') && !Schema::hasColumn('assets', 'type')) {
            if (DB::getDriverName() === 'sqlite') {
                DB::statement('ALTER TABLE assets RENAME COLUMN asset_type TO type');
            } else {
                DB::statement('ALTER TABLE assets CHANGE asset_type type VARCHAR(255)');
            }
        }
    }
};
