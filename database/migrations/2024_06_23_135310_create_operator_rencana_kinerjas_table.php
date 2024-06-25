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
        Schema::create('operator_rencana_kinerjas', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->ulid('tim_kerja_id');
            $table->foreign('tim_kerja_id')->references('id_timkerja')->on('tim_kerjas')->onDelete('cascade');
            $table->ulid('operator_id');
            $table->foreign('operator_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        // delete id_operator from tim_kerjas table
        Schema::table('tim_kerjas', function (Blueprint $table) {
            $table->dropForeign(['id_operator']);
            $table->dropColumn('id_operator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operator_rencana_kinerjas');
    }
};
