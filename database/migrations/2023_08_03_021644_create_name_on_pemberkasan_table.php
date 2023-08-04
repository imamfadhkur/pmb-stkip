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
        Schema::table('berkas_pendaftars', function (Blueprint $table) {
            $table->text('ijazah_skl_file')->after('ijazah_skl')->nullable();
            $table->text('skhun_file')->after('skhun')->nullable();
            $table->text('kk_file')->after('kk')->nullable();
            $table->text('ktp_file')->after('ktp')->nullable();
            $table->text('akta_file')->after('akta')->nullable();
            $table->text('pas_foto_file')->after('pas_foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_pendaftars', function (Blueprint $table) {
            $table->dropColumn('ijazah_skl_file');
            $table->dropColumn('skhun_file');
            $table->dropColumn('kk_file');
            $table->dropColumn('ktp_file');
            $table->dropColumn('akta_file');
            $table->dropColumn('pas_foto_file');
        });
    }
};
