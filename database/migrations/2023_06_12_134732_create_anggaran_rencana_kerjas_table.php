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
        Schema::create('anggaran_rencana_kerjas', function (Blueprint $table) {
            $table->ulid('id_rkanggaran')->unique()->primary()->default(Ulid::generate());
            $table->ulid('id_rencanakerja');
            $table->foreign('id_rencanakerja')->references('id_rencanakerja')->on('rencana_kerjas')->onDelete('cascade');
            $table->string('uraian');
            $table->string('satuan');
            $table->integer('volume');
            $table->bigInteger('harga');
            $table->bigInteger('total');
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
        Schema::dropIfExists('anggaran_rencana_kerjas');
    }
};
