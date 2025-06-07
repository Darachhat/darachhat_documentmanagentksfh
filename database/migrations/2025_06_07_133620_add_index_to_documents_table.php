<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Add composite index for efficient duplicate checking
            $table->index(['number', 'date'], 'documents_number_date_index');
            $table->index(['number'], 'documents_number_index');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropIndex('documents_number_date_index');
            $table->dropIndex('documents_number_index');
        });
    }
};
