<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->boolean('konfirmasi_klien')->default(false)->after('status_booking');
            $table->boolean('konfirmasi_freelancer')->default(false)->after('konfirmasi_klien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn(['konfirmasi_klien', 'konfirmasi_freelancer']);
        });
    }
};
