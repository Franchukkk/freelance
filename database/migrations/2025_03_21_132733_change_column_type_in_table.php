<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('projects', 'deadline')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->integer('deadline');
            });
        } else {
            Schema::table('projects', function (Blueprint $table) {
                $table->integer('deadline')->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }
};
