<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_index', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->float('nilai_index')->nullable();
            $table->enum('status', ['belum', 'lulus'])->default('belum');
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tabel_mahasiswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_index');
    }
};
