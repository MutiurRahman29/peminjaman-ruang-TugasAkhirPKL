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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_peminjaman');
            $table->unsignedInteger('id_fasilitas');
            $table->unsignedInteger('jumlah');
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->cascadeOnDelete();
            $table->foreign('id_fasilitas')->references('id_fasilitas')->on('fasilitas')->restrictOnDelete();

            $table->unique(['id_peminjaman', 'id_fasilitas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
