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
        Schema::dropIfExists('kompetensis');
        
        Schema::create('kompetensis', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('pegawai_id', 26);
            $table->foreign('pegawai_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('teknis_id');
            $table->text('nama_pelatihan');
            $table->text('sertifikat');
            $table->text('catatan')->nullable();
            $table->integer('status');
            $table->string('approved_by', 26)->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onUpdate('cascade');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->decimal('durasi', 5, 2);
            $table->date('tgl_sertifikat');
            $table->ulid('penyelenggara');
            $table->foreign('penyelenggara')->references('id')->on('master_penyelenggaras')->restrictOnDelete();
            $table->integer('jumlah_peserta')->nullable();
            $table->integer('ranking')->nullable();
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
        Schema::dropIfExists('kompetensis');
    }
};
