<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Ulid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagu_anggarans', function (Blueprint $table) {
            $table->ulid('id_panggaran')->primary()->default(Ulid::generate());
            $table->foreignUlid('id_manggaran')->references('id_manggaran')->on('master_anggarans');
            $table->year('tahun');
            $table->string('komponen');
            $table->string('akun');
            $table->string('uraian');
            $table->smallInteger('volume');
            $table->string('satuan');
            $table->bigInteger('harga');
            $table->bigInteger('pagu');
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
        Schema::dropIfExists('pagu_anggarans');
    }
};
