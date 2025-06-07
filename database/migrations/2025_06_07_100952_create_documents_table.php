<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['លិខិតចេញ', 'លិខិតចូល']);
            $table->string('number')->unique();
            $table->date('date');
            $table->string('source_file');
            $table->json('files'); // Store multiple file paths
            $table->text('description')->nullable();
            $table->text('other')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
