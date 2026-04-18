<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year'); // Tahun Akademik: 2024/2025
            $table->string('semester'); // Ganjil/Genap
            $table->string('title'); // Nama kegiatan
            $table->text('description')->nullable(); // Deskripsi
            $table->date('start_date'); // Tanggal mulai
            $table->date('end_date')->nullable(); // Tanggal selesai (opsional)
            $table->string('category')->default('academic'); // academic, exam, holiday, registration, etc
            $table->string('color')->default('#3498db'); // Warna untuk kalender
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_calendars');
    }
};
