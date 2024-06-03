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
        Schema::create('objek_kegiatans', function (Blueprint $table) {
            $table->ulid('id_okegiatan')->unique()->primary()->default(Ulid::generate());
            $table->string('kode_unitkerja');
            $table->string('nama_unitkerja');
            $table->string('kode_kegiatan');
            $table->string('nama');
            $table->string('is_active')->default(1);
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
        Schema::dropIfExists('objek_kegiatans');
    }
};
