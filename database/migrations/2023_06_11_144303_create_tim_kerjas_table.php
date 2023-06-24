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
            $table->ulid('id_timkerja')->primary()->default(Ulid::generate());
            $table->string('nama');
            $table->string('unitkerja');
            $table->string('id_iku');
            $table->string('id_ketua');
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
