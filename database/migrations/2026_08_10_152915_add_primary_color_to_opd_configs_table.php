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
        Schema::table('opd_configs', function (Blueprint $table) {
            $table->string('primary_color')->default('#f97316')->after('opd_id'); // Default warna oranye
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opd_configs', function (Blueprint $table) {
            $table->dropColumn('primary_color');
        });
    }
};
