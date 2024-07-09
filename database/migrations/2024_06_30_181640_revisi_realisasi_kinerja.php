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
        Schema::table('realisasi_kinerjas', function (Blueprint $table) {
            $table->dropColumn('alasan');
            $table->text('iki')->after('status');
            $table->text('rencana_kerja')->after('status');
            $table->text('kegiatan')->nullable(false)->change();
            $table->text('capaian')->nullable(false)->change();
            $table->ulid('id_laporan_objek')->after('status');
            $table->foreign('id_laporan_objek')->references('id')->on('laporan_objek_pengawasans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
