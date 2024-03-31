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
        // modify usulan_surat_srikandis table
        Schema::table('usulan_surat_srikandis', function (Blueprint $table) {
            $table->string('kegiatan_pengawasan', 100)->nullable();
            $table->string('pendukung_pengawasan', 100)->nullable();
            $table->string('jenis_naskah_dinas_korespondensi', 100)->nullable();
            $table->string('unsur_tugas', 100)->nullable();
            $table->string('perihal', 100)->nullable();
            // modify jenis_naskah_dinas_penugasan column to nullable
            $table->string('jenis_naskah_dinas_penugasan', 100)->nullable()->change();
            // modify kegiatan column to nullable
            $table->string('kegiatan', 100)->nullable()->change();
            // modify catatan column to nullable
            $table->string('catatan', 100)->nullable()->change();
            // modify nomor_surat column to nullable
            $table->string('nomor_surat', 100)->nullable()->change();
            // modify melaksanakan column to nullable
            $table->string('melaksanakan', 100)->nullable()->change();
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
