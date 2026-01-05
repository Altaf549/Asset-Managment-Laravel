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
        Schema::table('asset_assignments', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['assigned_to']);
            
            // Change the column to reference employees instead of users
            $table->unsignedBigInteger('assigned_to')->change();
            
            // Add new foreign key constraint to employees
            $table->foreign('assigned_to')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_assignments', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['assigned_to']);
            
            // Change back to users
            $table->unsignedBigInteger('assigned_to')->change();
            
            // Add foreign key constraint back to users
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
