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
        Schema::table('master_hasil_kerjas', function (Blueprint $table) {
            $table->string('pengendali_teknis')->nullable();
            $table->string('ketua_tim')->nullable();
            $table->string('anggota_tim');
            $table->string('pic')->comment('Person In Charge or Koodinator')->nullable();
            // delete hasil_kerja_tim
            $table->dropColumn('hasil_kerja_tim');
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
