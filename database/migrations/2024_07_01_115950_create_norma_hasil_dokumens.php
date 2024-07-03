<?php

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('norma_hasil_dokumens', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('laporan_pengawasan_id');
            $table->foreign('laporan_pengawasan_id')->references('id')->on('laporan_objek_pengawasans')->onDelete('restrict');
            $table->string('laporan_path', 255);
            $table->enum('status_verifikasi_arsiparis', ['belum unggah', 'diperiksa', 'disetujui', 'ditolak']);
            $table->string('catatan_arsiparis', 100)->nullable();
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
        Schema::dropIfExists('norma_hasil_dokumens');
    }
};
