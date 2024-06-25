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
        Schema::create('laporan_objek_pengawasans', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('id_objek_pengawasan');
            $table->foreign('id_objek_pengawasan')->references('id_opengawasan')->on('objek_pengawasans')->onDelete('cascade');
            $table->integer('month');
            $table->boolean('status');
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
        Schema::dropIfExists('laporan_objek_pengawasans');
    }
};
