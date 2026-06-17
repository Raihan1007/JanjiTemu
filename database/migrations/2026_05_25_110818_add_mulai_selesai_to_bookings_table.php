<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            
                $table->time('mulai')->nullable()->after('jam');
                $table->time('selesai')->nullable()->after('mulai');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            
                $table->dropColumn('mulai');
                $table->dropColumn('selesai');
        });
    }
};
