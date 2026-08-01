<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_dokumens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('surat_permohonan_id')->constrained('surat_permohonan')->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->string('jenis_dokumen'); // e.g. 'ktp', 'kk', 'akta', etc.
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_dokumens');
    }
};
