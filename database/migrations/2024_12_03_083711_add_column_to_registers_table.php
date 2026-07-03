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
        Schema::table('registers', function (Blueprint $table) {
            $table->unsignedBigInteger('pilihan4')->nullable()->after('pilihan3');
            $table->foreign('pilihan4')->references('id')->on('prodis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registers', function (Blueprint $table) {
            $table->dropForeign(['pilihan4']);
            $table->dropColumn('pilihan4');
        });
    }
};
