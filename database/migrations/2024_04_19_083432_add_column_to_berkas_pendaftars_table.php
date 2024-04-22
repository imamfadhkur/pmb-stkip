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
            $table->text('doc_pend_jalur_masuk')->after('pas_foto_file')->nullable();
            $table->text('doc_pend_jalur_masuk_file')->after('doc_pend_jalur_masuk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_pendaftars', function (Blueprint $table) {
            $table->dropColumn('doc_pend_jalur_masuk');
            $table->dropColumn('doc_pend_jalur_masuk_file');
        });
    }
};
