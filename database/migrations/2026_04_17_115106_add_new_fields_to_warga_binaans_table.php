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
        Schema::table('warga_binaans', function (Blueprint $table) {
            $table->date('tgl_msk_upt')->nullable();
            $table->date('tgl_ekspirasi')->nullable();
            $table->string('nm_alias_1')->nullable();
            $table->string('nm_alias_2')->nullable();
            $table->string('nm_alias_3')->nullable();
            $table->string('nm_kecil_1')->nullable();
            $table->string('nm_kecil_2')->nullable();
            $table->string('nm_kecil_3')->nullable();
            $table->string('lokasi_sel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warga_binaans', function (Blueprint $table) {
            $table->dropColumn([
                'tgl_msk_upt',
                'tgl_ekspirasi',
                'nm_alias_1',
                'nm_alias_2',
                'nm_alias_3',
                'nm_kecil_1',
                'nm_kecil_2',
                'nm_kecil_3',
                'lokasi_sel'
            ]);
        });
    }
};
