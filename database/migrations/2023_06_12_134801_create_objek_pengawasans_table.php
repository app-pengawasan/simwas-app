<?php

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objek_pengawasans', function (Blueprint $table) {
            $table->ulid('id_opengawasan')->primary()->default(Ulid::generate());
            $table->string('id_rencanakerja');
            $table->string('id_objek');
            $table->string('kategori_objek');
            $table->string('nama');
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
        Schema::dropIfExists('objek_pengawasans');
    }
};
