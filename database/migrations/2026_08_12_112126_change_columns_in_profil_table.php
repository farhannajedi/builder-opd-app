<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil', function (Blueprint $table) {
            $table->longText('penjelasan_tugas')->change()->nullable();
            $table->longText('tugas')->change()->nullable();
            $table->longText('fungsi')->change()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('profil', function (Blueprint $table) {
            $table->string('penjelasan_tugas')->change()->nullable();
            $table->string('tugas')->change()->nullable();
            $table->string('fungsi')->change()->nullable();
        });
    }
};
