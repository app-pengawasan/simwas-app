<?php

use Symfony\Component\Uid\Ulid;
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
        Schema::create('stpds', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('user_id', 26);
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_backdate');
            $table->date('tanggal')->nullable();
            $table->smallInteger('unit_kerja');
            $table->boolean('is_st_kinerja');
            $table->text('melaksanakan');
            $table->string('kota');
            $table->date('mulai');
            $table->date('selesai');
            $table->text('pelaksana');
            $table->string('no_surat')->nullable();
            $table->string('st_kinerja_id', 26)->nullable();
            $table->foreign('st_kinerja_id')->references('id')->on('st_kinerjas');
            $table->foreignId('pembebanan_id');
            $table->string('laporan')->nullable();
            $table->date('tanggal_laporan')->nullable();
            $table->string('penandatangan', 26)->nullable();
            $table->foreign('penandatangan')->references('id_pimpinan')->on('master_pimpinans');
            $table->smallInteger('status');
            $table->boolean('is_esign');
            $table->text('draft')->nullable();
            $table->text('file')->nullable();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('stpds');
    }
};
