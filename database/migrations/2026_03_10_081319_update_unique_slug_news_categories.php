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
        Schema::table('news_categories', function (Blueprint $table) {

            // hapus unique slug lama
            $table->dropUnique('news_categories_slug_unique');

            // buat unique baru kombinasi
            $table->unique(['opd_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_categories', function (Blueprint $table) {

            $table->dropUnique(['opd_id', 'slug']);

            $table->unique('slug');
        });
    }
};
