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
        Schema::create('pelaksana_tugas', function (Blueprint $table) {
            $table->ulid('id_pelaksana')->primary()->default(Ulid::generate());
            $table->string('id_rencanakerja');
            $table->string('id_pegawai');
            $table->string('pt_jabatan');
            $table->string('pt_hasil');
            $table->string('pt_realisasi')->nullable();
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
        Schema::dropIfExists('pelaksana_tugas');
    }
};
