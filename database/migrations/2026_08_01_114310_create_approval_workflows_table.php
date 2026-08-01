<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('surat_permohonan_id')->constrained('surat_permohonan')->cascadeOnDelete();
            $table->string('current_stage'); // ApprovalStage enum
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            $table->unique('surat_permohonan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_workflows');
    }
};
