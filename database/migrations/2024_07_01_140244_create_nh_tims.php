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
        Schema::create('nh_tims', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->integer('jenis');
            $table->ulid('tugas_id');
            $table->foreign('tugas_id')->references('id_rencanakerja')->on('rencana_kerjas')->onDelete('cascade');
            $table->ulid('laporan_id')->nullable();
            $table->foreign('laporan_id')->references('id')->on('norma_hasil_accepteds')->onDelete('cascade');
            $table->ulid('dokumen_id')->nullable();
            $table->foreign('dokumen_id')->references('id')->on('norma_hasil_dokumens')->onDelete('cascade');
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
        Schema::dropIfExists('nm_tims');
    }
};
