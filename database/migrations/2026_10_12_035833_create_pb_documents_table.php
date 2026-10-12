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
        Schema::create('pb_documents', function (Blueprint $table) {
        $table->id();
        $table->string('document_number', 100);
        $table->foreignId('topup_type_id')
            ->constrained('topup_types')
            ->restrictOnDelete();
        $table->foreignId('leader_id')
            ->nullable()
            ->constrained('leaders')
            ->nullOnDelete();
        $table->string('leader_name_snapshot', 150);
        $table->string('leader_position_snapshot', 100);
        $table->date('signature_date');
        $table->foreignId('created_by')
            ->constrained('users')
            ->restrictOnDelete();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pb_documents');
    }
};
