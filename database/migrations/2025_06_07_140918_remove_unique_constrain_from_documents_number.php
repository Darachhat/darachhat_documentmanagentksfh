<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if the unique constraint exists and remove it
        Schema::table('documents', function (Blueprint $table) {
            // Drop the unique constraint on number
            $table->dropUnique(['number']);
        });

        // Add composite unique constraint for number + type + year (date)
        // Note: SQLite doesn't support partial indexes easily, so we'll handle this in application logic
        Schema::table('documents', function (Blueprint $table) {
            // Add indexes for better performance
            $table->index(['number', 'type'], 'documents_number_type_index');
            $table->index(['number', 'date'], 'documents_number_date_index');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Re-add the unique constraint (but this might fail if duplicates exist)
            try {
                $table->unique('number');
            } catch (\Exception $e) {
                // Ignore if constraint cannot be added due to existing duplicates
            }

            // Drop the new indexes
            $table->dropIndex('documents_number_type_index');
            $table->dropIndex('documents_number_date_index');
        });
    }
};
