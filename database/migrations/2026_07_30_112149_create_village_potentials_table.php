<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('village_potentials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('category'); // Wisata, Pertanian, Peternakan, Perikanan, Kerajinan, Budaya, Investasi, SDA, UMKM
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('cover_image');
            $table->string('location')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('gallery_images')->nullable();
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_potentials');
    }
};
