<?php

use App\Models\Kompetensi;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kompetensis', function (Blueprint $table) {
            $table->timestamp('tgl_approve')->after('approved_by')->nullable();
            $table->timestamp('tgl_upload')->after('sertifikat')->nullable();
        });

        DB::statement('UPDATE kompetensis SET tgl_approve = created_at');
        DB::statement('UPDATE kompetensis SET tgl_upload = created_at');
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
