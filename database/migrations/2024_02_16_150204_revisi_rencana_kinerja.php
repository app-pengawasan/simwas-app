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
            // change id_hasilkerja tp foreign key to master_hasil_kerjas id
            $table->dropColumn('id_hasilkerja');
            $table->string('id_hasilkerja')->after('id_proyek');
            $table->foreign('id_hasilkerja')->references('id')->on('master_hasil_kerjas')->onDelete('cascade');
            // remove mulai and selesai column
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
        //
    }
};
