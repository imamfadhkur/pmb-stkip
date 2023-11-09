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
        // Tambahkan kolom sisa_kuota pada tabel prodis
        Schema::table('prodis', function (Blueprint $table) {
            $table->integer('sisa_kuota')->default(0)->after('kuota');
        });

        DB::unprepared('
            CREATE PROCEDURE update_sisa_kuota()
            BEGIN
                DECLARE prodi_id INT;
                DECLARE total_registers INT;
            
                -- Loop through each prodi
                DECLARE prodi_cursor CURSOR FOR SELECT id FROM prodis;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET prodi_id = NULL;
            
                OPEN prodi_cursor;
            
                prodi_loop: LOOP
                    FETCH prodi_cursor INTO prodi_id;
                    IF prodi_id IS NULL THEN
                        LEAVE prodi_loop;
                    END IF;
            
                    -- Calculate total registers for the current prodi
                    SET total_registers = (
                        SELECT COUNT(*)
                        FROM registers
                        WHERE diterima_di = prodi_id
                    );
            
                    -- Update sisa_kuota for the current prodi
                    UPDATE prodis
                    SET sisa_kuota = kuota - total_registers
                    WHERE id = prodi_id;
                END LOOP;
            
                CLOSE prodi_cursor;
            END;
        ');

        DB::unprepared('
            CREATE TRIGGER after_registers_change_insert
            AFTER INSERT ON registers
            FOR EACH ROW
            BEGIN
                CALL update_sisa_kuota();
            END;
            
            CREATE TRIGGER after_registers_change_update
            AFTER UPDATE ON registers
            FOR EACH ROW
            BEGIN
                CALL update_sisa_kuota();
            END;
            
            CREATE TRIGGER after_registers_change_delete
            AFTER DELETE ON registers
            FOR EACH ROW
            BEGIN
                CALL update_sisa_kuota();
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->dropColumn('sisa_kuota');

        // Drop stored procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS update_sisa_kuota');

        // Drop trigger
        DB::unprepared('DROP TRIGGER IF EXISTS after_registers_change_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_registers_change_update');
        DB::unprepared('DROP TRIGGER IF EXISTS after_registers_change_delete');
        });
    }
};
