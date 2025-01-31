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
            $table->string('nama_dokumen', 500)->change();
        });
        Schema::table('objek_pengawasans', function (Blueprint $table) {
            $table->string('nama_laporan', 500)->change();
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
