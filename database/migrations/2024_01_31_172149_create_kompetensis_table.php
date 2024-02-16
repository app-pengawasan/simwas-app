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
        Schema::create('kompetensis', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('pegawai_id', 26);
            $table->foreign('pegawai_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('pp_id');
            $table->foreign('pp_id')->references('id')->on('pps')->onDelete('cascade');
            $table->text('pp_lain')->nullable();
            $table->unsignedBigInteger('nama_pp_id');
            $table->foreign('nama_pp_id')->references('id')->on('nama_pps')->onDelete('cascade');
            $table->text('nama_pp_lain')->nullable();
            $table->text('sertifikat');
            $table->text('catatan')->nullable();
            $table->integer('status');
            $table->string('approved_by', 26)->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onUpdate('cascade');
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
