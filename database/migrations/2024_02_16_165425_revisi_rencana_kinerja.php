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
        Schema::table('rencana_kerjas', function (Blueprint $table) {
            $table->string('melaksanakan')->after('id_proyek');
            $table->string('capaian')->after('melaksanakan');
        });
        // add work hour monthly from jan to dec to pelaksana_tugas table
        Schema::table('pelaksana_tugas', function (Blueprint $table) {
            $table->integer('jan')->after('pt_realisasi');
            $table->integer('feb')->after('jan');
            $table->integer('mar')->after('feb');
            $table->integer('apr')->after('mar');
            $table->integer('mei')->after('apr');
            $table->integer('jun')->after('mei');
            $table->integer('jul')->after('jun');
            $table->integer('agu')->after('jul');
            $table->integer('sep')->after('agu');
            $table->integer('okt')->after('sep');
            $table->integer('nov')->after('okt');
            $table->integer('des')->after('nov');
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
