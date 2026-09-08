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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->increments('id_peminjaman');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_ruangan');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->text('keperluan');
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak', 'Selesai'])->default('Menunggu');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->restrictOnDelete();
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->restrictOnDelete();

            $table->index(['id_ruangan', 'tanggal', 'jam_mulai', 'jam_selesai']);
            $table->index(['id_user', 'tanggal']);
            $table->index(['status', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
