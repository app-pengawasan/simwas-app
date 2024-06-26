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
        Schema::create('realisasi_kinerjas', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('id_pelaksana', 26);
            $table->foreign('id_pelaksana')->references('id_pelaksana')->on('pelaksana_tugas');
            $table->integer('status');
            $table->text('kegiatan')->nullable();
            $table->text('capaian')->nullable();
            $table->text('hasil_kerja')->nullable();
            $table->text('catatan')->nullable();
            $table->text('alasan')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->string('penilai', 26)->nullable();
            $table->foreign('penilai')->references('id')->on('users')->onUpdate('cascade');
            $table->text('catatan_penilai')->nullable();
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
        Schema::dropIfExists('realisasi_kinerjas');
    }
};
