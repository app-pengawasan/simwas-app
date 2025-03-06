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
        Schema::create('isi_changelog', function (Blueprint $table) {
            $table->increments('id_isichangelog');
            $table->unsignedInteger('id_judulchangelog');
            $table->foreign('id_judulchangelog')->references('id_judulchangelog')->on('judul_changelog')->onDelete('cascade');
            $table->string('isi', 50);
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
        Schema::dropIfExists('isi_changelog');
    }
};
