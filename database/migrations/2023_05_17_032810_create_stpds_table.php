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
        Schema::create('stpds', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            //$table->foreignId('pp_id');
            $table->smallInteger('unit_kerja');
            $table->text('melaksanakan');
            $table->string('kota');
            $table->date('mulai');
            $table->date('selesai');
            $table->string('pelaksana');
            $table->string('no_st')->nullable();
            $table->foreignId('st_kinerja_id');
            $table->string('pembebanan'); //pembebanan ni apa?
            $table->string('laporan');
            $table->date('tanggal_laporan');
            $table->smallInteger('penandatangan');
            $table->smallInteger('status');
            $table->boolean('is_esign');
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
