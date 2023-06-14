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
        Schema::create('kkas', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->boolean('is_aktif');
            $table->timestamps();
        });

        Schema::table('st_kinerjas', function (Blueprint $table) {
            $table->foreign('penandatangan')
                  ->references('id_pimpinan')
                  ->on('master_pimpinans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kkas');
    }
};
