<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Ulid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_iku_unit_kerjas', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('unit_kerja', 100);
            $table->integer('jumlah_objek');
            $table->string('nama_kegiatan', 100);
            $table->timestamps();
        });
        Schema::create('objek_iku_unit_kerjas', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('nama_objek', 100);
            $table->string('satuan', 100);
            $table->foreignId('target_iku_unit_kerja_id')->constrained('target_iku_unit_kerjas')->onDelete('cascade');
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
        Schema::dropIfExists('target_iku_unit_kerjas');
    }
};
