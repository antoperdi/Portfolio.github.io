<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
            $table->string('primary_opacity', 10)->nullable()->default('0.85')->after('primary_color');
            $table->string('navigator_color', 10)->nullable()->after('accent_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn(['primary_opacity', 'navigator_color']);
        });
    }
};
