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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained("projects")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('sender_id')
                ->constrained("users")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('receiver_id')
                ->constrained("users")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('amount');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
