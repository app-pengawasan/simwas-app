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
        Schema::create('master_iku', function (Blueprint $table) {
            $table->ulid('id_iku')->unique()->primary()->default(Ulid::generate());
            $table->ulid('id_sasaran');
            $table->foreign('id_sasaran')->references('id_sasaran')->on('master_sasarans')->onDelete('restrict');
            $table->string('iku');
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
        Schema::dropIfExists('master_iku');
    }
};
