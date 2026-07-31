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
        Schema::create('village_statistics', function (Blueprint $table) {
            $table->id();
            
            // Angka Utama
            $table->integer('total_population')->default(0);
            $table->integer('total_family')->default(0);
            $table->integer('total_dusun')->default(0);
            $table->integer('total_rt')->default(0);
            $table->integer('total_rw')->default(0);
            
            // Demografi JSON
            $table->json('gender_data')->nullable(); // {"laki_laki": 0, "perempuan": 0}
            $table->json('education_data')->nullable(); // {"sd": 0, "smp": 0, "sma": 0, "s1": 0}
            $table->json('job_data')->nullable(); // {"petani": 0, "pns": 0, "wiraswasta": 0, "nelayan": 0}
            $table->json('age_data')->nullable(); // {"0_14": 0, "15_64": 0, "65_plus": 0}
            $table->json('religion_data')->nullable(); // {"islam": 0, "kristen": 0, "katolik": 0, "hindu": 0, "buddha": 0, "konghucu": 0}
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_statistics');
    }
};
