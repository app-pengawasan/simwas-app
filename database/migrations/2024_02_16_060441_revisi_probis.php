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
        Schema::table('tim_kerjas', function (Blueprint $table) {
            $table->string('id_operator')->nullable();
            $table->foreign('id_operator')->references('id')->on('users');
            $table->string('uraian_tugas')->nullable();
            $table->string('renca_kerja_ketua')->nullable();
            $table->string('iki_ketua')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
