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
        Schema::dropIfExists('pps');
        Schema::dropIfExists('nama_pps');

        Schema::create('kategori_kompetensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('jenis_kompetensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori_kompetensis')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('teknis_kompetensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_id');
            $table->foreign('jenis_id')->references('id')->on('jenis_kompetensis')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::table('kompetensis', function (Blueprint $table) {
            $table->foreign('teknis_id')->references('id')->on('teknis_kompetensis')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pps');
        Schema::dropIfExists('nama_pps');
    }
};
