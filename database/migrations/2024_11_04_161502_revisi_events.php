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
        Schema::dropIfExists('events');

        Schema::create('events', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('laporan_opengawasan', 26);
            $table->foreign('laporan_opengawasan')->references('id')->on('laporan_objek_pengawasans')->onDelete('cascade');
            $table->string('id_pegawai', 26);
            $table->foreign('id_pegawai')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('aktivitas');
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
        Schema::dropIfExists('events');
    }
};
