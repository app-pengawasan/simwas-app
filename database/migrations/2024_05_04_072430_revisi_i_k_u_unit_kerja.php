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
        //
        // add id_objek that references to id_objek in master_objeks table
        Schema::table('objek_iku_unit_kerjas', function (Blueprint $table) {
            $table->string('id_objek')->nullable();
            $table->foreign('id_objek')->references('id_objek')->on('master_objeks');
            // delete satuan
            $table->dropColumn('satuan');
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
