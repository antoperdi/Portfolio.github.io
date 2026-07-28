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
        Schema::create('my_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');                  // Judul/Nama gambar
            $table->string('image_path');             // Lokasi penyimpanan file gambar (misal: galleries/foto.jpg)
            $table->text('caption')->nullable();      // Deskripsi/Keterangan opsional
            $table->boolean('is_active')->default(true); // Status tampil/tidaknya gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_galleries');
    }
};
