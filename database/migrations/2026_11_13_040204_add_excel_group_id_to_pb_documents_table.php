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
        Schema::table('pb_documents', function (Blueprint $table) {
            $table->uuid('excel_group_id')
                ->nullable()
                ->after('id')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pb_documents', function (Blueprint $table) {
            $table->dropColumn('excel_group_id');
        });
    }
};
