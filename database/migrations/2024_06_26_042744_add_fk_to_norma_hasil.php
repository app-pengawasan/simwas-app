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
        Schema::table('norma_hasils', function (Blueprint $table) {
            $table->ulid('laporan_pengawasan_id')->after('id')->nullable();
            $table->foreign('laporan_pengawasan_id')->references('id')->on('laporan_objek_pengawasans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('norma_hasil', function (Blueprint $table) {
            //
            $table->dropForeign(['laporan_pengawasan_id']);
            $table->dropColumn('laporan_pengawasan_id');
            $table->dropForeign(['jenis_norma_hasil_id']);
            $table->string('jenis_norma_hasil');
        });
    }
};
