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
        Schema::create('master_kinerjas', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('hasil_kerja_id');
            $table->foreign('hasil_kerja_id')->references('id')->on('master_hasil_kerjas')->onDelete('restrict');
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
        Schema::dropIfExists('master_kinerjas');
    }
};
