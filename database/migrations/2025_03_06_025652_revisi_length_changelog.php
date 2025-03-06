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
        Schema::table('judul_changelog', function (Blueprint $table) {
            $table->string('judul', 100)->change();
            $table->text('keterangan')->change();
        });

        Schema::table('isi_changelog', function (Blueprint $table) {
            $table->text('isi')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
