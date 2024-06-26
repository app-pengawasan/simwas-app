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
        Schema::create('master_sasarans', function (Blueprint $table) {
            $table->ulid('id_sasaran')->unique()->primary()->default(Ulid::generate());
            $table->ulid('id_tujuan');
            $table->foreign('id_tujuan')->references('id_tujuan')->on('master_tujuans')->onDelete('restrict');
            $table->string('sasaran');
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
        Schema::dropIfExists('master_sasarans');
    }
};
