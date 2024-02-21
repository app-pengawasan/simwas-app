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
        Schema::create('data_kepegawaians', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('id_pegawai', 26);
            $table->foreign('id_pegawai')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('jenis', false, true);
            $table->foreign('jenis')->references('id')->on('master_data_kepegawaians')->onDelete('cascade');
            $table->decimal('nilai', 5, 2);
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
        Schema::dropIfExists('data_kepegawaians');
    }
};
