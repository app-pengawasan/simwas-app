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
        Schema::create('master_objeks', function (Blueprint $table) {
            $table->ulid('id_objek')->primary()->unique()->default(Ulid::generate());
            $table->string('nama');
            $table->string('kode_wilayah')->nullable();
            $table->string('kode_unitkerja')->nullable();
            $table->string('kode_satuankerja')->nullable();
            $table->string('kategori');
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
        Schema::dropIfExists('master_objeks');
    }
};