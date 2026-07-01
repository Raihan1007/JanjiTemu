<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->foreignId('kategori_booking_id')
                  ->after('layanan_id')
                  ->constrained('kategori_bookings')
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropForeign(['kategori_booking_id']);
            $table->dropColumn('kategori_booking_id');

        });
    }
};