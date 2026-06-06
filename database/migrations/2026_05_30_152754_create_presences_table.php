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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitation')->onDelete('cascade');
            $table->string('nama_mhs');
            $table->enum('status', ['mahasiswa', 'alumni', 'ortu'])->default('mahasiswa');
            $table->string('wa_mhs');
            $table->string('nama_ortu_1')->nullable();
            $table->string('nama_ortu_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
