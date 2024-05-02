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
        Schema::create('st_tims', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('tugas_id', 26);
            $table->foreign('tugas_id')->references('id_rencanakerja')->on('rencana_kerjas');
            $table->string('nomor', 100);
            $table->string('nama', 100);
            $table->string('path', 100);
            $table->enum('status', ['diperiksa', 'disetujui', 'ditolak']);
            $table->string('catatan', 100)->nullable();
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
        Schema::dropIfExists('st_tims');
    }
};
