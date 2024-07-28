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
        Schema::table('kompetensis', function (Blueprint $table) {
            $table->date('tgl_mulai')->before('catatan');
            $table->date('tgl_selesai')->before('catatan');
            $table->decimal('durasi', 5, 2)->before('catatan');
            $table->date('tgl_sertifikat')->before('sertifikat');
            $table->ulid('penyelenggara')->before('catatan');
            $table->foreign('penyelenggara')->references('id')->on('master_penyelenggaras')->restrictOnDelete();
            $table->integer('jumlah_peserta')->before('catatan')->nullable();
            $table->integer('ranking')->before('catatan')->nullable();
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
