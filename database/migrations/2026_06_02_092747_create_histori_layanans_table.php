<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histori_layanans', function (Blueprint $table) {

            $table->id();

            $table->string('nama')->nullable();
            $table->string('nik')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_hp')->nullable();

            $table->string('layanan')->nullable();

            $table->date('tanggal')->nullable();

            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();

            $table->integer('durasi')->nullable();

            $table->decimal('survey',5,2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histori_layanans');
    }
};
