<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_verifikasi_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('surat_permohonan_id')->constrained('surat_permohonan')->cascadeOnDelete();
            $table->string('verification_hash', 64);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('verification_hash');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_verifikasi_logs');
    }
};
