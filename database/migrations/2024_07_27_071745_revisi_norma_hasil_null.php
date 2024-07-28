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
        // allow null in user_id in norma_hasils table
        Schema::table('norma_hasils', function (Blueprint $table) {
            $table->string('user_id')->nullable()->change();
            $table->ulid('tugas_id')->nullable()->change();
        });
        // allow null in norma_hasil_accepteds table
        Schema::table('nh_tims', function (Blueprint $table) {
            $table->ulid('tugas_id')->nullable()->change();
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
