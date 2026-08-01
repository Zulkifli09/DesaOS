<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_timelines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('surat_permohonan_id')->constrained('surat_permohonan')->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');          // SuratStatus value
            $table->string('stage')->nullable(); // ApprovalStage value
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();

            $table->index('surat_permohonan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_timelines');
    }
};
