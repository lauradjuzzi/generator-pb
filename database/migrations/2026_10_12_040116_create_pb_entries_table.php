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
        Schema::create('pb_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pb_section_id')
                ->constrained('pb_sections')
                ->cascadeOnDelete();

            $table->string('entry_type', 10);
            $table->date('date_from');
            $table->date('date_until')->nullable();
            $table->string('account_number', 50);
            $table->string('account_name', 150);
            $table->text('description')->nullable();
            $table->decimal('amount', 18, 2);

            $table->timestamps();

            $table->index(['pb_section_id', 'entry_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pb_entries');
    }
};
