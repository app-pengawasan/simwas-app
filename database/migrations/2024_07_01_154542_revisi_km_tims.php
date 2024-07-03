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
        Schema::table('km_tims', function (Blueprint $table) {
            $table->dropForeign('km_tims_tugas_id_foreign');
            $table->dropColumn('tugas_id');
            $table->ulid('laporan_pengawasan_id')->after('id');
            $table->foreign('laporan_pengawasan_id')->references('id')->on('laporan_objek_pengawasans')->cascadeOnDelete();
            $table->text('path')->change();
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
