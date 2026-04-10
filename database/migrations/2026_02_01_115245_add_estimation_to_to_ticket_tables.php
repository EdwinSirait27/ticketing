<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_tables', function (Blueprint $table) {
             $table->dateTime('estimation_to')
                  ->nullable()
                  ->after('estimation');
        });
    }
    public function down(): void
    {
        Schema::table('ticket_tables', function (Blueprint $table) {
        });
    }
};