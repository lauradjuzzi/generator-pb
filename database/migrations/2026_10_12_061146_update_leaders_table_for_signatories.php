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
        Schema::table('leaders', function (Blueprint $table) {
            $table->string('signatory_type', 30)
                ->default('PIMPINAN')
                ->after('id');

            $table->string('first_position', 100)
                ->nullable()
                ->after('signatory_type');

            $table->string('first_name', 150)
                ->nullable()
                ->after('first_position');

            $table->string('second_position', 100)
                ->nullable()
                ->after('first_name');

            $table->string('second_name', 150)
                ->nullable()
                ->after('second_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaders', function (Blueprint $table) {
            $table->dropColumn([
                'signatory_type',
                'first_position',
                'first_name',
                'second_position',
                'second_name',
            ]);
        });
    }
};
