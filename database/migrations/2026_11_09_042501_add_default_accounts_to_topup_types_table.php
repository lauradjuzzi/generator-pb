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
        Schema::table('topup_types', function (Blueprint $table) {
            $table->string('default_debit_account_number', 50)->nullable();
            $table->string('default_debit_account_name', 150)->nullable();
            $table->text('default_debit_description')->nullable();

            $table->string('default_credit_account_number', 50)->nullable();
            $table->string('default_credit_account_name', 150)->nullable();
            $table->text('default_credit_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topup_types', function (Blueprint $table) {
            $table->dropColumn([
                'default_debit_account_number',
                'default_debit_account_name',
                'default_debit_description',
                'default_credit_account_number',
                'default_credit_account_name',
                'default_credit_description',
            ]);
        });
    }
};