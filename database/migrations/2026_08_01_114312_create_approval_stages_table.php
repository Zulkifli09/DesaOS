<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_stages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('approval_workflow_id')->constrained('approval_workflows')->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('stage');   // ApprovalStage enum
            $table->string('action'); // approved, rejected, revision
            $table->text('catatan')->nullable();
            $table->timestamp('actioned_at')->nullable();
            $table->timestamps();

            $table->index('approval_workflow_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_stages');
    }
};
