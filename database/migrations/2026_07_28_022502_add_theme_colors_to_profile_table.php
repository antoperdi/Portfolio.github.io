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
        Schema::table('profile', function (Blueprint $table) {
            $table->string('primary_color', 10)->nullable()->after('profile_pic');
            $table->string('secondary_color', 10)->nullable()->after('primary_color');
            $table->string('accent_color', 10)->nullable()->after('secondary_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn(['primary_color', 'secondary_color', 'accent_color']);
        });
    }
};
