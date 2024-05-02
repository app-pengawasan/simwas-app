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
        //
        // update norma_hasils table\
        Schema::table('norma_hasils', function (Blueprint $table) {
            // remove old Norma Hasil columns
            $table->dropColumn('is_backdate');
            $table->dropColumn('hal');
            // $table->dropColumn('st_kinerja_id');
            // drop st_kinerja_id foreign key
            $table->dropForeign(['st_kinerja_id']);
            $table->dropColumn('st_kinerja_id');
            $table->dropColumn('draft');
            $table->dropColumn('no_surat');
            $table->dropColumn('status');
            $table->dropColumn('surat');
            $table->dropColumn('catatan');
            // Add new columns
            // Usulan Norma Hasil
            $table->string('tugas_id', 100);
            $table->foreign('tugas_id')->references('id_rencanakerja')->on('rencana_kerjas');
            $table->string('jenis_norma_hasil_id', 100);
            $table->string('nama_dokumen', 100);
            $table->string('document_path', 100);
            // enum status_norma_hasil =  diperiksa, ditolak, disetujui
            $table->string('catatan_norma_hasil', 100)->nullable();
            $table->enum('status_norma_hasil', ['diperiksa', 'ditolak', 'disetujui']);

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
