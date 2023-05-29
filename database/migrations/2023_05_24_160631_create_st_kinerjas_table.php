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
        Schema::create('st_kinerjas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('rencana_id');
            $table->text('melaksanakan');
            $table->string('objek');
            $table->date('mulai');
            $table->date('selesai');
            $table->smallInteger('penandatangan');
            $table->smallInteger('status');
            $table->string('norma_hasil')->nullable();
            $table->string('no_st')->nullable();
            $table->boolean('is_esign');
            $table->text('file')->nullable();
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
        Schema::dropIfExists('st_kinerjas');
    }
};
