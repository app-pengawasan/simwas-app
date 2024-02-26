<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Ulid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objek_iku_unit_kerjas', function (Blueprint $table) {

            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('satuan', 100);
            $table->string('id_target', 100);
            $table->foreign('id_target')->references('id')->on('target_iku_unit_kerjas')->onDelete('cascade');
            $table->integer('nilai_y_target');
            $table->integer('target_triwulan_1');
            $table->integer('target_triwulan_2');
            $table->integer('target_triwulan_3');
            $table->integer('target_triwulan_4');
            $table->integer('nilai_y_realisasi')->nullable();
            $table->integer('realisasi_triwulan_1')->nullable();
            $table->integer('realisasi_triwulan_2')->nullable();
            $table->integer('realisasi_triwulan_3')->nullable();
            $table->integer('realisasi_triwulan_4')->nullable();
            $table->string('status', 100);
            $table->string('user_id', 100);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objek_iku_unit_kerjas');
    }
};
