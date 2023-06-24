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
        Schema::create('kirims', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('no_surat');
            $table->string('user_id', 26);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('email_tujuan');
            $table->text('pesan');
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
        Schema::dropIfExists('kirims');
    }
};
