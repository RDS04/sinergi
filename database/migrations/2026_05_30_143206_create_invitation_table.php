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
            $table->enum('status', ['mahasiswa', 'alumni'])->default('mahasiswa');
            $table->bigInteger('wa_mhs')->unsigned()->unique();
            $table->enum('attendance_status', ['belum_hadir', 'hadir'])->default('belum_hadir');
            $table->string('nama_ortu_1')->nullable()->comment('Nama orang tua/wali (required for mahasiswa)');
            $table->string('nama_ortu_2')->nullable()->comment('Nama orang tua/wali kedua (optional)');
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
