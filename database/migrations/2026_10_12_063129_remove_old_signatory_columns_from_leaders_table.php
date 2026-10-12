
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leaders', function (Blueprint $table) {
            $table->dropColumn(['name', 'position']);
        });
    }

    public function down(): void
    {
        Schema::table('leaders', function (Blueprint $table) {
            $table->string('position', 100);
            $table->string('name', 150);
        });
    }
};
