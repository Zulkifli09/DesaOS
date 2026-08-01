<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_permohonan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_surat')->unique()->nullable();
            $table->foreignUuid('surat_template_id')->nullable()->constrained('surat_templates')->nullOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('jenis_surat');         // JenisSurat enum value
            $table->string('status')->default('draft'); // SuratStatus enum value
            $table->string('nama_pemohon');
            $table->string('nik_pemohon', 16);
            $table->text('alamat_pemohon');
            $table->string('no_hp_pemohon', 20)->nullable();
            $table->text('keperluan');
            $table->json('data_tambahan')->nullable(); // Extra fields per surat type
            $table->text('catatan_pemohon')->nullable();
            $table->text('catatan_operator')->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('verification_hash', 64)->unique()->nullable();
            $table->string('verification_url')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('current_stage')->nullable(); // ApprovalStage
            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->date('estimasi_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('nomor_surat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_permohonan');
    }
};
