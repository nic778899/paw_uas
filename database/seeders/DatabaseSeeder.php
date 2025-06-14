<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengaturan_absensis')->insert([
            'check_in' => '10:00',
            'check_out' => '18:00',
            'rentang_awal_IP' => '000.000.000.000',
            'rentang_akhir_IP' => '999.999.999.999', 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('jabatan_organisasis')->insert([
            [
            'nama_jabatan' => 'Marketing',
            'besaran_gaji' =>  2500000,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_jabatan' => 'Kerajinan',
            'besaran_gaji'=> 2500000,
             'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_jabatan' => 'Office Boy',
            'besaran_gaji'=> 1500000,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'nama_jabatan' => 'Keamanan',
            'besaran_gaji' => 1500000,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'nama_jabatan' => 'Chef',
            'besaran_gaji'=> 2000000,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'nama_jabatan' => 'Admin',
            'besaran_gaji' => 2500000,
            'created_at' => now(),
            'updated_at' => now(),
            ]

        ]);

         // Buat user
        DB::table('users')->insert([
            [
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => Hash::make('secret'),
            'role' => 'admin',
            ],
            [
                'name' => 'pegawai',
                'email' => 'pegawai@gmail.com',
                'password' => Hash::make(12345678),
                'role' => 'pegawai',
            ],
        ]);

        DB::table('data_pribadis')->insert([
            'tanggal_lahir' => '2000-01-25',
            'tempat_lahir' => 'palembang',
            'created_at' => '2025-01-25 09:00:00',
            'updated_at' => '2025-01-25 09:00:00',
            'user_id' => 2,
            'jabatan_organisasi_id' => 1
        ]);

        DB::table('absensis')->insert([
            [
                'status_absensi' => 'datang',
                'created_at' => '2025-01-25 09:00:00',
                'updated_at' => '2025-01-25 09:00:00',
                'user_id' => 2
            ],
            [
                'status_absensi' => 'pulang',
                'created_at' => '2025-01-25 18:02:00',
                'updated_at' => '2025-01-25 18:02:00',
                'user_id' => 2
            ],
            [
                'status_absensi' => 'datang',
                'created_at' => '2024-12-25 09:30:00',
                'updated_at' => '2024-12-25 09:30:00',
                'user_id' => 2
            ],
            [
                'status_absensi' => 'pulang',
                'created_at' => '2024-12-25 18:30:00',
                'updated_at' => '2024-12-25 18:30:00',
                'user_id' => 2
            ],
            [
                'status_absensi' => 'datang',
                'created_at' => '2023-12-25 09:00:00',
                'updated_at' => '2023-12-25 09:00:00',
                'user_id' => 2
            ],
            [
                'status_absensi' => 'pulang',
                'created_at' => '2023-12-25 19:00:00',
                'updated_at' => '2023-12-25 19:00:00',
                'user_id' => 2
            ],
        ]);

       
    }
}
