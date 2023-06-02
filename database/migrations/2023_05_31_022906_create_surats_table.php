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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nomor_surat');
            $table->string('derajat_klasifikasi', 2);
            $table->integer('nomor_naskah');
            $table->string('nomor_organisasi', 4);
            $table->string('kka', 6);
            $table->date('tanggal');
            $table->string('jenis');
            $table->integer('backdate')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('surats');
    }
};
