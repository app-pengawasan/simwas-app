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
        // change type of column (jan, feb, mar, apr, mei, jun, jul, agu, sep, okt, nov, des) in pelaksana_tugas table to decimal one digit after comma
        Schema::table('pelaksana_tugas', function (Blueprint $table) {
            $table->decimal('jan', 5, 1)->change();
            $table->decimal('feb', 5, 1)->change();
            $table->decimal('mar', 5, 1)->change();
            $table->decimal('apr', 5, 1)->change();
            $table->decimal('mei', 5, 1)->change();
            $table->decimal('jun', 5, 1)->change();
            $table->decimal('jul', 5, 1)->change();
            $table->decimal('agu', 5, 1)->change();
            $table->decimal('sep', 5, 1)->change();
            $table->decimal('okt', 5, 1)->change();
            $table->decimal('nov', 5, 1)->change();
            $table->decimal('des', 5, 1)->change();
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
