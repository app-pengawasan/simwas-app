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
        Schema::create('tim_kerjas', function (Blueprint $table) {
            $table->ulid('id_timkerja')->unique()->primary()->default(Ulid::generate());
            $table->string('nama');
            $table->string('unitkerja');
            $table->ulid('id_iku');
            $table->foreign('id_iku')->references('id_iku')->on('master_iku')->onDelete('restrict');
            $table->ulid('id_ketua');
            $table->foreign('id_ketua')->references('id')->on('users')->onDelete('restrict');
            $table->integer('status')->default(0);
            $table->year('tahun');
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
        Schema::dropIfExists('tim_kerjas');
    }
};
