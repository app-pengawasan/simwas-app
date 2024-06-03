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
        // Drop foreign key constraint first
    Schema::table('stpds', function (Blueprint $table) {
        $table->dropForeign(['st_kinerja_id']);
    });

    // Now drop the tables
    Schema::dropIfExists('eksternals');
    Schema::dropIfExists('kirims');
    Schema::dropIfExists('master_hasils');
    Schema::dropIfExists('kkas');
    Schema::dropIfExists('pembebanans');
    Schema::dropIfExists('st_kinerjas');
    Schema::dropIfExists('sls');
    Schema::dropIfExists('stpds');
    Schema::dropIfExists('stps');
    Schema::dropIfExists('surats');
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
