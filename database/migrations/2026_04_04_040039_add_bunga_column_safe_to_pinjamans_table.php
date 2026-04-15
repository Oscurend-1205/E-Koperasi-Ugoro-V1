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
        if (!Schema::hasColumn('pinjamans', 'bunga')) {
            Schema::table('pinjamans', function (Blueprint $table) {
                $table->decimal('bunga', 5, 2)->default(0)->after('tenor');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('pinjamans', 'bunga')) {
            Schema::table('pinjamans', function (Blueprint $table) {
                $table->dropColumn('bunga');
            });
        }
    }
};
