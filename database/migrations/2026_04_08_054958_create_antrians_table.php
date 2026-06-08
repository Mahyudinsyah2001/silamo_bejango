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
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_antrian')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nik', 16);
            $table->string('foto_identitas')->nullable();
            $table->text('alamat');
            $table->string('no_tlp');
            $table->string('hubungan');
            $table->date('tanggal_kunjungan');
            $table->foreignId('sesi_id')->constrained('sesis')->onDelete('cascade');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
