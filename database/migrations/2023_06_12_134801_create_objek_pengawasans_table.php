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
        Schema::create('objek_pengawasans', function (Blueprint $table) {
            $table->ulid('id_opengawasan')->unique()->primary()->default(Ulid::generate());
            $table->string('id_rencanakerja');
            $table->foreign('id_rencanakerja')->references('id_rencanakerja')->on('rencana_kerjas')->onDelete('cascade');
            $table->ulid('id_objek');
            $table->foreign('id_objek')->references('id_objek')->on('master_objeks')->onDelete('restrict');
            $table->string('kategori_objek');
            $table->string('nama');
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
        Schema::dropIfExists('objek_pengawasans');
    }
};
