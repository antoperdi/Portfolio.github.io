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
        Schema::create('Project_Saya', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('image_path')->nullable();
            $table->text('caption')->nullable();
            $table->text('Work_Story')->nullable();
            $table->text('Main_Features')->nullable();
            $table->string('Kategori')->nullable();
            $table->string('Tanggal_Proyek')->nullable();
            $table->string('Role')->nullable();
            $table->text('Teknologi')->nullable();
            $table->string('url_code')->nullable();
            $table->string('url_demo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Project_Saya');
    }
};
