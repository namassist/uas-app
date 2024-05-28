<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('iurans')->insert([
            'id_warga' => 1,
            'bulan' => '2024-01-01',
            'jumlah_iuran' => 10000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('iurans')->insert([
            'id_warga' => 1,
            'bulan' => '2024-02-01',
            'jumlah_iuran' => 10000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('iurans')->insert([
            'id_warga' => 1,
            'bulan' => '2023-01-01',
            'jumlah_iuran' => 50000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('iurans')->insert([
            'id_warga' => 1,
            'bulan' => '2023-02-01',
            'jumlah_iuran' => 50000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        DB::table('iurans')->insert([
            'id_warga' => 2,
            'bulan' => '2024-01-01',
            'jumlah_iuran' => 10000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('iurans')->insert([
            'id_warga' => 2,
            'bulan' => '2024-02-01',
            'jumlah_iuran' => 10000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('iurans')->insert([
            'id_warga' => 2,
            'bulan' => '2023-01-01',
            'jumlah_iuran' => 50000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('iurans')->insert([
            'id_warga' => 2,
            'bulan' => '2023-02-01',
            'jumlah_iuran' => 50000,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
