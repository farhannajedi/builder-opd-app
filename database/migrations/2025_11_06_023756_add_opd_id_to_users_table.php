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
        Schema::table('users', function (Blueprint $table) {
            // tambahkan kolom opd_id dan relasi ke tabel opds
            $table->foreignId('opd_id')->nullable()->constrained('opds')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // hapus relasi dan kolom ketika rollback
            $table->dropForeign(['opd_id']);
            $table->dropColumn('opd_id');
        });
    }
};
