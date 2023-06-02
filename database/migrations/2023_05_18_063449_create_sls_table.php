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
        Schema::create('sls', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('user_id', 26);
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_backdate');
            $table->date('tanggal');
            $table->string('jenis_surat');
            $table->string('derajat_klasifikasi', 2);
            $table->foreignId('kka_id');
            $table->string('unit_kerja');
            $table->text('hal');
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
        Schema::dropIfExists('sls');
    }
};
