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
        Schema::create('master_hasils', function (Blueprint $table) {
            $table->ulid('id_master_hasil')->primary()->default(Ulid::generate());
            $table->string('unsur');
            $table->string('subunsur1');
            $table->string('subunsur2');
            $table->string('kategori_hasilkerja');
            $table->string('kategori_pelaksana');
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
        Schema::dropIfExists('master_hasils');
    }
};
