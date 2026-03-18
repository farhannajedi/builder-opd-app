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
        Schema::create('profil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->constrained()->onDelete('cascade');
            $table->string('nama_kepala_dinas')->nullable();
            $table->text('sambutan_kepala')->nullable();
            $table->string('gambar')->nullable();
            $table->text('tentang_kami')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('penjelasan_tugas')->nullable();
            $table->string('tugas')->nullable();
            $table->string('fungsi')->nullable();
            $table->string('bagan_struktur')->nullable();
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil');
    }
};
