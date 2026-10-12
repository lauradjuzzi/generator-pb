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
        Schema::create('pb_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pb_document_id')
                ->constrained('pb_documents')
                ->cascadeOnDelete();

            $table->string('section_type', 30);
            $table->timestamps();

            $table->unique(
                ['pb_document_id', 'section_type'],
                'pb_sections_document_type_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pb_sections');
    }
};
