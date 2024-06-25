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

        // change relation to on delete restrict in rencana_kerjas table   $table->foreign('id_proyek')->references('id')->on('proyeks')->onDelete('cascade');\
        Schema::table('rencana_kerjas', function (Blueprint $table) {
            $table->dropForeign(['id_proyek']);
            $table->foreign('id_proyek')->references('id')->on('proyeks')->onDelete('restrict');
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
