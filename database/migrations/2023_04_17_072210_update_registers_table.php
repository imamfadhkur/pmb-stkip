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
            $table->enum('pembayaran', ['sudah', 'belum'])->default('belum')->after('identitas_kewarganegaraan');
            $table->unsignedBigInteger('jenjang_pendidikan_id')->after('pembayaran');
            $table->foreign('jenjang_pendidikan_id')->references('id')->on('jenjang_pendidikans')->after('jenjang_pendidikan_id');
            $table->unsignedBigInteger('sistem_kuliah_id')->after('jenjang_pendidikan_id');
            $table->foreign('sistem_kuliah_id')->references('id')->on('sistem_kuliahs')->after('sistem_kuliah_id');
            $table->unsignedBigInteger('jalur_masuk_id')->after('sistem_kuliah_id');
            $table->foreign('jalur_masuk_id')->references('id')->on('jalur_masuks')->after('jalur_masuk_id');
            $table->unsignedBigInteger('pilihan1')->after('jalur_masuk_id');
            $table->foreign('pilihan1')->references('id')->on('prodis')->after('pilihan1');
            $table->unsignedBigInteger('pilihan2')->after('pilihan1');
            $table->foreign('pilihan2')->references('id')->on('prodis')->after('pilihan2');
            $table->unsignedBigInteger('pilihan3')->after('pilihan2');
            $table->foreign('pilihan3')->references('id')->on('prodis')->after('pilihan3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registers', function (Blueprint $table) {
            $table->dropColumn('pembayaran');
        });
    }
};
