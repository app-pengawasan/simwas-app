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
        Schema::create('evaluasi_iku_unit_kerjas', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('id_target_iku_unit_kerja', 100);
            $table->foreign('id_target_iku_unit_kerja')->references('id')->on('target_iku_unit_kerjas');
            $table->string('kendala', 255);
            $table->string('solusi', 255);
            $table->string('tindak_lanjut', 255);
            $table->ulid('id_pic', 255);
            $table->foreign('id_pic')->references('id')->on('users');
            // batas waktu tindak lanjut
            $table->timestamp('batas_waktu_tindak_lanjut');
            $table->string('uraian_tindak_lanjut', 255);
            $table->string('link_tindak_lanjut', 255);
            $table->string('dokumen_daftar_hadir_path', 255);
            $table->string('dokumen_undangan_path', 255);
            $table->string('dokumen_notulen_path', 255);
            $table->string('dokumen_laporan_path', 255);
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
        Schema::dropIfExists('evaluasi_iku_unit_kerjas');
    }
};
