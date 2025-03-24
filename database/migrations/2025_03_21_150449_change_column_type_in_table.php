<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bids', 'deadline_time')) {
            Schema::table('bids', function (Blueprint $table) {
                $table->integer('deadline_time');
            });
        } else {
            Schema::table('bids', function (Blueprint $table) {
                $table->integer('deadline_time')->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn('deadline_time');
        });
    }
};
