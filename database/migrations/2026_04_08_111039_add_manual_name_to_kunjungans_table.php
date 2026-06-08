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
        // SQLite doesn't support changing foreign keys easily, so we recreate the table
        Schema::dropIfExists('kunjungans');
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrian_id')->constrained('antrians')->onDelete('cascade');
            $table->foreignId('warga_binaan_id')->nullable()->constrained('warga_binaans')->onDelete('cascade');
            $table->string('nama_warga_binaan_manual')->nullable();
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original strict structure
        Schema::dropIfExists('kunjungans');
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrian_id')->constrained('antrians')->onDelete('cascade');
            $table->foreignId('warga_binaan_id')->constrained('warga_binaans')->onDelete('cascade');
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
};
