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
        Schema::create('tasktimers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('task_id');
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->timestamps();

            $table->foreign('task_id')       ->references('id')      ->on('projects')    ->onDelete('cascade');
            $table->foreign('user_id')          ->references('id')      ->on('users')       ->onDelete('cascade');

            $table->unique(['user_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasktimers');
    }
};
