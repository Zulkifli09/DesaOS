<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_announcements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->text('isi');
            $table->string('tipe')->default('info'); // info, warning, success, danger
            $table->boolean('is_active')->default(true);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_announcements');
    }
};
