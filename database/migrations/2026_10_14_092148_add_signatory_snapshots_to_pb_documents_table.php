<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pb_documents', function (Blueprint $table) {
            $table->string('signatory_type', 30)->nullable();

            $table->string('first_signatory_position', 100)->nullable();
            $table->string('first_signatory_name', 150)->nullable();

            $table->string('second_signatory_position', 100)->nullable();
            $table->string('second_signatory_name', 150)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pb_documents', function (Blueprint $table) {
            $table->dropColumn([
                'signatory_type',
                'first_signatory_position',
                'first_signatory_name',
                'second_signatory_position',
                'second_signatory_name',
            ]);
        });
    }
};