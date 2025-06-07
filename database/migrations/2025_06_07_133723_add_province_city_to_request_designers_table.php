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
        Schema::table('request_designers', function (Blueprint $table) {
            $table->string('province')->after('design_reference_path');
            $table->string('city')->after('province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_designers', function (Blueprint $table) {
            $table->dropColumn(['province', 'city']);
        });
    }
};
