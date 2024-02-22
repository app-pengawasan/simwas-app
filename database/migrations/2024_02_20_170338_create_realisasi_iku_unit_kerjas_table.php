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
        Schema::create('realisasi_iku_unit_kerjas', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('id_target_iku_unit_kerja', 100);
            $table->foreign('id_target_iku_unit_kerja')->references('id')->on('target_iku_unit_kerjas');
            $table->string('catatan', 100);
            $table->string('dokumen_sumber_path', 100);
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
        Schema::dropIfExists('realisasi_iku_unit_kerjas');
    }
};
