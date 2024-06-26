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
        Schema::create('kode_klasifikasi_arsips', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            
            $table->string('kode')->unique();
            $table->string('uraian');
            $table->boolean('is_aktif')->default(true);
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
        Schema::dropIfExists('kode_klasifikasi_arsips');
    }
};
