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
        Schema::table('pelaksana_tugas', function (Blueprint $table) {
            //
            // drop column pt_hasil
            $table->dropColumn('pt_hasil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelaksana_tugas', function (Blueprint $table) {
            //
        });
    }
};
