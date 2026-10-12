
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom tanda tangan sudah tersedia di database.
        // Tidak perlu menambahkan kolom lagi.
    }

    public function down(): void
    {
        // Tidak menghapus kolom karena kolom sudah ada
        // sebelum migration ini dijalankan.
    }
};
