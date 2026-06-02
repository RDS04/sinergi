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
        Schema::create('invitation', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mhs');
            $table->enum('status', ['mahasiswa', 'alumni', 'ortu'])->default('mahasiswa');
            $table->string('wa_mhs');
            $table->enum('attendance_status', ['belum_hadir', 'hadir'])->default('belum_hadir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation');
    }
};
