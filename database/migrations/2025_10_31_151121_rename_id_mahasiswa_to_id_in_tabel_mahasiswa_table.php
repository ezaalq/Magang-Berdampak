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
        // Drop foreign keys from related tables
        Schema::table('absens', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('alasan', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('nilai_index', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });

        // Rename column first, then modify to auto-increment
        Schema::table('tabel_mahasiswa', function (Blueprint $table) {
            $table->renameColumn('id_mahasiswa', 'id');
        });

        // Recreate foreign keys
        Schema::table('absens', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('alasan', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('laporan', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('nilai_index', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id')->on('tabel_mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys from related tables
        Schema::table('absens', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('alasan', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('nilai_index', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->dropForeign(['id_mahasiswa']);
        });

        // Drop primary key and rename column back
        Schema::table('tabel_mahasiswa', function (Blueprint $table) {
            $table->dropPrimary();
            $table->renameColumn('id', 'id_mahasiswa');
            $table->primary('id_mahasiswa');
        });

        // Recreate foreign keys referencing id_mahasiswa
        Schema::table('absens', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('alasan', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('laporan', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('nilai_index', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tabel_mahasiswa')->onDelete('cascade');
        });
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tabel_mahasiswa')->onDelete('cascade');
        });
    }
};
