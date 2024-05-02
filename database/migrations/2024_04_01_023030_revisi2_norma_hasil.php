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

        // add rencana_kerja_id to usulan_surat_srikandis
        Schema::table('usulan_surat_srikandis', function (Blueprint $table) {
            $table->string('rencana_kerja_id')->nullable();
            $table->foreign('rencana_kerja_id')->references('id_rencanakerja')->on('rencana_kerjas');
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
