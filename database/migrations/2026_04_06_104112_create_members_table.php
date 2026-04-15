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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nia')->unique();
            $table->string('name');
            $table->decimal('deposit_pokok', 15, 2)->default(0);
            $table->decimal('deposit_wajib', 15, 2)->default(0);
            $table->decimal('deposit_monosuko', 15, 2)->default(0);
            $table->decimal('deposit_dpu', 15, 2)->default(0);
            $table->decimal('deposit_total', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
