<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('jenis_surat')->index(); // JenisSurat enum
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->json('persyaratan')->nullable();     // Array of required docs
            $table->json('fields_config')->nullable();   // Dynamic form fields config
            $table->longText('template_pdf')->nullable(); // HTML template for PDF
            $table->integer('estimasi_hari')->default(3);
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_templates');
    }
};
