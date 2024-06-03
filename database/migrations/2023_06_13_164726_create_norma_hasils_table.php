<?php

use Symfony\Component\Uid\Ulid;
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
        Schema::create('norma_hasils', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->boolean('is_backdate');
            $table->date('tanggal')->nullable();
            $table->string('unit_kerja');
            $table->text('hal');
            $table->string('st_kinerja_id', 26);
            $table->foreign('st_kinerja_id')->references('id')->on('st_kinerjas');
            $table->text('draft');
            $table->string('no_surat')->nullable();
            $table->smallInteger('status');
            $table->string('surat')->nullable();
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
        Schema::dropIfExists('norma_hasils');
    }
};
