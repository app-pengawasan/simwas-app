<?php

use Illuminate\Support\Facades\DB;
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
        Schema::table('norma_hasils', function (Blueprint $table) {
            $table->string('document_path', 500)->change();
        });

        Schema::table('realisasi_kinerjas', function (Blueprint $table) {
            $table->timestamp('tgl_upload')->after('hasil_kerja')->nullable();
        });

        DB::statement('UPDATE realisasi_kinerjas SET tgl_upload = updated_at');
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
