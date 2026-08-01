<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_pengaduan')->unique()->nullable();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('kategori');       // PengaduanKategori enum
            $table->string('prioritas')->default('sedang'); // PengaduanPrioritas enum
            $table->string('status')->default('menunggu');  // PengaduanStatus enum
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->text('catatan_petugas')->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->date('tanggal_pengaduan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->date('estimasi_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('nomor_pengaduan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
