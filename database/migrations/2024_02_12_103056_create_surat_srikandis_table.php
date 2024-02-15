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
        Schema::create('surat_srikandis', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('id_usulan_surat_srikandi');
            $table->foreign('id_usulan_surat_srikandi')->references('id')->on('usulan_surat_srikandis')->onDelete('cascade');
            $table->string('jenis_naskah_dinas_srikandi');
            $table->date('tanggal_persetujuan_srikandi');
            $table->string('nomor_surat_srikandi');
            $table->string('derajat_keamanan_srikandi');
            $table->string('kode_klasifikasi_arsip_srikandi');
            $table->string('perihal_srikandi');
            $table->string('kepala_unit_penandatangan_srikandi');
            $table->string('link_srikandi');
            $table->string('document_srikandi_word_path');
            $table->string('document_srikandi_pdf_path');
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('surat_srikandis');
    }
};
