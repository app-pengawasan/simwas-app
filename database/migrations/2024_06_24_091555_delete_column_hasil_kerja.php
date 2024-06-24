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
        // delete pengendali_teknis, ketua_tim, anggota_tim, pic from master_hasil_kerjas table
        Schema::table('master_hasil_kerjas', function (Blueprint $table) {
            $table->dropColumn('pengendali_teknis');
            $table->dropColumn('ketua_tim');
            $table->dropColumn('anggota_tim');
            $table->dropColumn('pic');
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
