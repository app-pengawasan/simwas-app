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
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('nip');
            $table->string('name');
            $table->string('pangkat');
            $table->string('unit_kerja');
            $table->string('jabatan');
            $table->boolean('is_aktif');
            $table->boolean('is_admin');
            $table->boolean('is_sekma');
            $table->boolean('is_sekwil');
            $table->boolean('is_perencana');
            $table->boolean('is_apkapbn');
            $table->boolean('is_opwil');
            $table->boolean('is_analissdm');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
