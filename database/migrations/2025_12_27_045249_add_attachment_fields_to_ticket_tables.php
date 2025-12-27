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
             $table->string('attachment_folder')->nullable()->after('description')->nullable();
        $table->text('attachment_url')->nullable()->after('attachment_folder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_tables', function (Blueprint $table) {
        $table->dropColumn([
            'attachment_folder',
            'attachment_url',
        ]);
    });
    }
};
