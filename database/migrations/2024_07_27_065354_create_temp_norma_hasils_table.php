<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_norma_hasils', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor');
            $table->date('tanggal');
            $table->string('document_path');
            $table->string('unit_kerja');
            $table->string('jenis_norma_hasil'); //refer ke kode lha/lhe
            $table->string('nama_dokumen');
            $table->string('status_norma_hasil'); //disetujui semua
            $table->string('kode_klasifikasi_arsip'); //PW.120
            $table->string('laporan_path');


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
        Schema::dropIfExists('temp_norma_hasils');
    }
};
