<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan_komentars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pengaduan_id')->constrained('pengaduans')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('komentar');
            $table->boolean('is_internal')->default(false); // Internal staff note
            $table->timestamps();
            $table->softDeletes();

            $table->index('pengaduan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_komentars');
    }
};
