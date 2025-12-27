<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     protected $connection = 'mysql';
    /**
     * Run the migrations.
     */
    public function up(): void
  {
        Schema::connection($this->connection)->create('ticket_attachment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // relasi ke ticket_tables (MYSQL)
            $table->uuid('ticket_id')->nullable(); 
            $table->string('file_name')->nullable(); 
            $table->string('file_path')->nullable(); 
            $table->timestamps();
            $table->foreign('ticket_id')
                  ->references('id')
                  ->on('ticket_tables')
                  ->cascadeOnDelete();
            $table->index('ticket_id');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('ticket_attachment');
    }
};
