<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'level' => 'superadmin',
        ]);

        DB::table('jalur_masuks')->insert([
            'nama' => 'Registrasi Utama',
            'status' => 'aktif'
        ]);
        DB::table('jalur_masuks')->insert([
            'nama' => 'Putra/putri Guru',
            'status' => 'aktif'
        ]);
        DB::table('jalur_masuks')->insert([
            'nama' => 'On The Spot',
            'status' => 'aktif'
        ]);
        DB::table('jalur_masuks')->insert([
            'nama' => 'SBMPTN',
            'status' => 'tidak aktif'
        ]);
        DB::table('jenjang_pendidikans')->insert(['nama' => 'S1']);
        DB::table('sistem_kuliahs')->insert(['nama' => 'reguler']);
        DB::table('informasi_kampuses')->insert(['name' => 'STKIP PGRI Bangkalan']);
        DB::table('banks')->insert([
            'nama_pemilik' => 'STKIP PGRI BANGKALAN'
        ]);
        
        // \App\Models\User::factory(50)->create();
        // \App\Models\Register::factory(50)->create();

    }
}
