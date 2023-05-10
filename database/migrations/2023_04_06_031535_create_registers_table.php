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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->string('hp');
            $table->string('email')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('kewarganegaraan');
            $table->string('identitas_kewarganegaraan');
            $table->unsignedBigInteger('jenjang_pendidikan_id');
            $table->foreign('jenjang_pendidikan_id')->references('id')->on('jenjang_pendidikans');
            $table->unsignedBigInteger('sistem_kuliah_id');
            $table->foreign('sistem_kuliah_id')->references('id')->on('sistem_kuliahs');
            $table->unsignedBigInteger('jalur_masuk_id');
            $table->foreign('jalur_masuk_id')->references('id')->on('jalur_masuks');
            $table->string('nama_sekolah');
            $table->string('jenis_sekolah');
            $table->string('jurusan_sekolah');
            $table->year('tahun_lulus');
            $table->text('alamat_sekolah');
            $table->unsignedBigInteger('pilihan1');
            $table->foreign('pilihan1')->references('id')->on('prodis');
            $table->unsignedBigInteger('pilihan2');
            $table->foreign('pilihan2')->references('id')->on('prodis');
            $table->unsignedBigInteger('pilihan3');
            $table->foreign('pilihan3')->references('id')->on('prodis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
