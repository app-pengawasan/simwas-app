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
            $table->ulid('id')->unique()->primary()->default(Ulid::generate());
            $table->string('email', 64)->unique();
            $table->string('password', 64)->nullable();
            $table->string('nip', 18);
            $table->string('name', 64);
            $table->string('pangkat', 4);
            $table->string('unit_kerja', 4);
            $table->string('jabatan', 2);
            $table->boolean('is_aktif')->default(1);
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_sekma')->default(0);
            $table->boolean('is_sekwil')->default(0);
            $table->boolean('is_perencana')->default(0);
            $table->boolean('is_arsiparis')->default(0);
            $table->boolean('is_apkapbn')->default(0);
            $table->boolean('is_opwil')->default(0);
            $table->boolean('is_analissdm')->default(0);
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