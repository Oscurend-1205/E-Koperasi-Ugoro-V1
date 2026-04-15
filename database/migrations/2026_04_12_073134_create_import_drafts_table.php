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
        Schema::create('import_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The admin who uploaded
            $table->string('file_name')->nullable();
            $table->string('type')->default('anggota'); // anggota, simpanan, pinjaman
            $table->json('data'); // Bulk data from Excel
            $table->string('status')->default('draft'); // draft, confirmed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_drafts');
    }
};
