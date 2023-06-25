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
        Schema::create('st_kinerjas', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->date('tanggal')->nullable();
            $table->string('user_id', 26);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('unit_kerja');
            $table->integer('tim_kerja');
            $table->integer('tugas');
            $table->text('melaksanakan');
            $table->string('objek');
            $table->date('mulai');
            $table->date('selesai');
            $table->boolean('is_gugus_tugas');
            $table->boolean('is_perseorangan')->nullable();
            $table->string('dalnis_id', 26)->nullable();
            $table->foreign('dalnis_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('ketua_koor_id', 26)->nullable();
            $table->foreign('ketua_koor_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('anggota')->nullable();
            $table->string('penandatangan', 26)->nullable();
            $table->foreign('penandatangan')->references('id_pimpinan')->on('master_pimpinans');
            $table->smallInteger('status');
            $table->string('no_surat')->nullable();
            $table->text('draft')->nullable();
            $table->text('file')->nullable();
            $table->boolean('is_esign');
            $table->boolean('is_backdate');
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
