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
        Schema::create('nama_pps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pp_id')->nullable();
            $table->bigInteger('peserta')->nullable();
            $table->string('nama');
            $table->boolean('is_aktif');
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
        Schema::dropIfExists('nama_pps');
    }
};
