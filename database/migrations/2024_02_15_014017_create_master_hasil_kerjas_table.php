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
        Schema::create('master_hasil_kerjas', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('master_subunsur_id');
            $table->foreign('master_subunsur_id')->references('id')->on('master_sub_unsurs')->onDelete('cascade');
            $table->string('nama_hasil_kerja');
            $table->string('hasil_kerja_tim');
            $table->string('pengendali_teknis')->nullable();
            $table->string('ketua_tim')->nullable();
            $table->string('anggota_tim');
            $table->string('pic')->comment('Person In Charge or Koodinator')->nullable();
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
        Schema::dropIfExists('master_hasil_kerjas');
    }
};
