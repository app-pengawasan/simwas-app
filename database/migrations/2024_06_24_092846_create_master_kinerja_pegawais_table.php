<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\Uid\Ulid;
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
        Schema::create('master_kinerja_pegawais', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('kinerja_id');
            $table->foreign('kinerja_id')->references('id')->on('master_kinerjas');
            $table->string('hasil_kerja', 100);
            $table->string('rencana_kinerja', 100);
            $table->string('iki', 100);
            $table->string('kegiatan', 100);
            $table->string('capaian', 100);
            $table->enum('pt_jabatan', ['1', '2', '3', '4', '5']);
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
        Schema::dropIfExists('master_kinerja_pegawais');
    }
};
