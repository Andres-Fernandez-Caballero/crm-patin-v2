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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('image')->default('default-topic.jpg');
            $table->double('price', 8, 2);
            $table->timestamps();
        });

        Schema::create('topicables', function (Blueprint $table) {
            $table->integer('topic_id');
            $table->integer('topicable_id');
            $table->string('topicable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
        Schema::dropIfExists('topicables');
    }
};
