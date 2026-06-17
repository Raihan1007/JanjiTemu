<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('email');
            $table->string('nomor_hp');

            $table->foreignId('layanan_id')->constrained('layanans')->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('petugas')->cascadeOnDelete();

            $table->date('tanggal');
            $table->time('jam');
            $table->string('link_meet')->nullable();

            $table->timestamps();

            // Anti double booking
            $table->unique(['petugas_id', 'tanggal', 'jam'], 'unique_booking');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
