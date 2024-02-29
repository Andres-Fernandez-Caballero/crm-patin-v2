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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('names', 30);
            $table->string('last_name', 30);
            $table->string('dni')->unique();
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->enum('state', ['regular', 'pago pendiente', 'inactivo'])->default('pago pendiente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
