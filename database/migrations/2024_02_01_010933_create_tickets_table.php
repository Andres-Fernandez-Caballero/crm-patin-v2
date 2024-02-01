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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students');
            $table->date('period_start');
            $table->date('paid_date')->nullable(); 
            $table->boolean('is_expired')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });

        Schema::create('ticket_topic', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')->constrained('tickets');
            $table->foreignId('topic_id')->constrained('topics');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
