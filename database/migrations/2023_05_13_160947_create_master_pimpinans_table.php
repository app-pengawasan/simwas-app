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
        Schema::create('master_pimpinans', function (Blueprint $table) {
            $table->ulid('id_pimpinan')->unique()->primary()->default(Ulid::generate());
            $table->ulid('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('jabatan', 6);
            $table->date('mulai');
            $table->date('selesai');
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
        Schema::dropIfExists('master_pimpinans');
    }
};
