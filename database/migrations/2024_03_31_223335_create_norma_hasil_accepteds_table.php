<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Ulid;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('norma_hasil_accepteds', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('id_norma_hasil');
            $table->foreign('id_norma_hasil')->references('id')->on('norma_hasils')->onDelete('cascade');
            $table->integer('nomor_norma_hasil');
            $table->string('kode_norma_hasil', 100);
            $table->string('kode_klasifikasi_arsip', 100);
            $table->date('tanggal_norma_hasil');
            $table->string('laporan_path', 255)->nullable();
            $table->enum('status_verifikasi_arsiparis', ['belum unggah', 'diperiksa', 'disetujui', 'ditolak']);
            $table->string('catatan_arsiparis', 100)->nullable();
            $table->string('unit_kerja', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('norma_hasil_accepteds');
    }
};
