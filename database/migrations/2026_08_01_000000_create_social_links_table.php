<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('url', 255);
            $table->string('icon_path', 255)->nullable();
            $table->integer('order_num')->default(0);
            $table->timestamps();
        });

        // Seed data awal agar tampilan portfolio tidak kosong
        DB::table('social_links')->insert([
            [
                'name' => 'GitHub',
                'url' => 'https://github.com/',
                'icon_path' => 'foto_pribadi/github.png',
                'order_num' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'LinkedIn',
                'url' => '#',
                'icon_path' => 'foto_pribadi/linkedin.png',
                'order_num' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://www.instagram.com/rhqmat_?igsh=MWM5MGdmaTc5aG1kMA==',
                'icon_path' => 'foto_pribadi/instagram.png',
                'order_num' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'YouTube',
                'url' => 'https://youtube.com/@rakhmatperdianto7616?si=sywZYvvMX5NpZPnY',
                'icon_path' => 'foto_pribadi/youtube.png',
                'order_num' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
