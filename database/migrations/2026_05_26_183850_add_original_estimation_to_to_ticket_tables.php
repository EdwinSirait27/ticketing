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
        Schema::table('ticket_tables', function (Blueprint $table) {
            $table->timestamp('original_estimation_to')
                ->nullable()
                ->after('estimation_to')
                ->comment('Deadline asli sebelum di-extend (untuk hitung SLA yang jujur)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_tables', function (Blueprint $table) {
            $table->dropColumn('original_estimation_to');
        });
    }
};