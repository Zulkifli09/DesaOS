<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type');              // NotificationType enum
            $table->string('judul');
            $table->text('pesan');
            $table->string('url')->nullable();   // Action link
            $table->json('data')->nullable();    // Additional metadata
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->string('channel')->default('database'); // database, email, whatsapp
            $table->string('notifiable_type')->nullable();  // Polymorphic
            $table->string('notifiable_id')->nullable();    // Polymorphic
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
