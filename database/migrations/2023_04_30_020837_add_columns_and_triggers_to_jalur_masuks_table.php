<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jalur_masuks', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_pendaftar')->default(0)->after('biaya');
            $table->unsignedInteger('jumlah_maks_pendaftar')->default(1)->after('jumlah_pendaftar');
        });
    
        // Add trigger to update jumlah_pendaftar column
        DB::unprepared('
        CREATE TRIGGER jalur_masuks_jumlah_pendaftar_trigger
        AFTER INSERT ON registers
        FOR EACH ROW
        BEGIN
            UPDATE jalur_masuks
            SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = NEW.jalur_masuk_id)
            WHERE id = NEW.jalur_masuk_id;
        END
        ');

        DB::unprepared('
        CREATE TRIGGER trg_delete_register
            AFTER DELETE ON registers
            FOR EACH ROW
            BEGIN
                UPDATE jalur_masuks
                SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = OLD.jalur_masuk_id)
                WHERE id = OLD.jalur_masuk_id;
            END
        ');

        DB::unprepared('
        CREATE TRIGGER trg_update_register
        AFTER UPDATE ON registers
        FOR EACH ROW
        BEGIN
            UPDATE jalur_masuks
            SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = NEW.jalur_masuk_id)
            WHERE id = NEW.jalur_masuk_id;
            UPDATE jalur_masuks
            SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = OLD.jalur_masuk_id)
            WHERE id = OLD.jalur_masuk_id;
        END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the trigger first
        DB::unprepared('DROP TRIGGER IF EXISTS jalur_masuks_jumlah_pendaftar_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_delete_register');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_update_register');

        // Then drop the columns
        Schema::table('jalur_masuks', function (Blueprint $table) {
            $table->dropColumn('jumlah_pendaftar');
            $table->dropColumn('jumlah_maks_pendaftar');
        });
    }
};
