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
        // add id_proyek to rencana_kerjas table
        Schema::table('rencana_kerjas', function (Blueprint $table) {
            $table->string('id_proyek')->nullable()->after('id_timkerja');
            $table->foreign('id_proyek')->references('id')->on('proyeks')->onDelete('cascade');

            $table->foreign('id_hasilkerja')->references('id')->on('master_hasil_kerjas')->onDelete('cascade');
            $table->dropColumn('mulai');
            $table->dropColumn('selesai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rencana_kerjas', function (Blueprint $table) {
            $table->dropForeign(['id_proyek']);
            $table->dropForeign(['id_hasilkerja']);
            $table->dropColumn('id_proyek');
            $table->dropColumn('id_hasilkerja');

            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
        });
    }
};
