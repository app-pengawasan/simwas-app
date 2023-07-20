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
        Schema::create('rencana_kerjas', function (Blueprint $table) {
            $table->ulid('id_rencanakerja')->unique()->primary()->default(Ulid::generate());
            $table->string('id_timkerja');
            $table->string('id_hasilkerja');
            $table->string('kategori_pelaksanatugas');
            $table->string('tugas');
            $table->date('mulai');
            $table->date('selesai');
            $table->integer('status_realisasi')->default(0);
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
        Schema::dropIfExists('rencana_kerjas');
    }
};