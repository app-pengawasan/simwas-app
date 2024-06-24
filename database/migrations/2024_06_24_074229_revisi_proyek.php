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
        // delete rencana_kinerja_anggota, iki_anggota from proyek table
        Schema::table('proyeks', function (Blueprint $table) {
            $table->dropColumn('rencana_kinerja_anggota');
            $table->dropColumn('iki_anggota');
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
