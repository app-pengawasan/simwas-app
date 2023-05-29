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
        Schema::create('eksternals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->smallInteger('pengirim');
            $table->date('tanggal_ekspedisi');
            $table->string('penerima_ekspedisi');
            $table->date('tanggal_dok');
            $table->string('penerima_dok');
            $table->string('asal');
            $table->string('no_surat');
            $table->date('tanggal_surat');
            $table->text('perihal');
            $table->integer('jumlah_hal');
            $table->boolean('is_tembusan');
            $table->boolean('is_disposisi');
            $table->date('tanggal_dispo')->nullable();
            $table->smallInteger('kepada')->nullable();
            $table->text('file');
            $table->smallInteger('status');
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('eksternals');
    }
};
