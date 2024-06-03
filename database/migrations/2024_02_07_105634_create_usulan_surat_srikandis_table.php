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
        Schema::create('usulan_surat_srikandis', function (Blueprint $table) {
            // ulid
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('nomor_surat', 100);
            $table->string('pejabat_penanda_tangan', 100);
            $table->string('jenis_naskah_dinas', 100);
            $table->string('jenis_naskah_dinas_penugasan', 100);
            $table->string('kegiatan', 100);
            $table->string('derajat_keamanan', 100);
            $table->string('kode_klasifikasi_arsip', 100);
            $table->string('melaksanakan', 100);
            $table->date('usulan_tanggal_penandatanganan');
            $table->string('directory', 255);
            $table->string('catatan', 100);
            $table->string('status', 100);
            $table->ulid('user_id');
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
        Schema::dropIfExists('usulan_surat_srikandis');
    }
};
