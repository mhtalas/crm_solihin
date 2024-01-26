<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->delete();
        $provinces = array(
            ['id' => 1, 'name' => 'Aceh'],
            ['id' => 2, 'name' => 'Sumatera Utara'],
            ['id' => 3, 'name' => 'Sumatera Barat'],
            ['id' => 4, 'name' => 'Riau'],
            ['id' => 5, 'name' => 'Jambi'],
            ['id' => 6, 'name' => 'Sumatera Selatan'],
            ['id' => 7, 'name' => 'Bengkulu'],
            ['id' => 8, 'name' => 'Lampung'],
            ['id' => 9, 'name' => 'Kepulauan Bangka Belitung'],
            ['id' => 10, 'name' => 'Kepulauan Riau'],
            ['id' => 11, 'name' => 'Dki Jakarta'],
            ['id' => 12, 'name' => 'Jawa Barat'],
            ['id' => 13, 'name' => 'Jawa Tengah'],
            ['id' => 14, 'name' => 'Di Yogyakarta'],
            ['id' => 15, 'name' => 'Jawa Timur'],
            ['id' => 16, 'name' => 'Banten'],
            ['id' => 17, 'name' => 'Bali'],
            ['id' => 18, 'name' => 'Nusa Tenggara Barat'],
            ['id' => 19, 'name' => 'Nusa Tenggara Timur'],
            ['id' => 20, 'name' => 'Kalimantan Barat'],
            ['id' => 21, 'name' => 'Kalimantan Tengah'],
            ['id' => 22, 'name' => 'Kalimantan Selatan'],
            ['id' => 23, 'name' => 'Kalimantan Timur'],
            ['id' => 24, 'name' => 'Kalimantan Utara'],
            ['id' => 25, 'name' => 'Sulawesi Utara'],
            ['id' => 26, 'name' => 'Sulawesi Tengah'],
            ['id' => 27, 'name' => 'Sulawesi Selatan'],
            ['id' => 28, 'name' => 'Sulawesi Tenggara'],
            ['id' => 29, 'name' => 'Gorontalo'],
            ['id' => 30, 'name' => 'Sulawesi Barat'],
            ['id' => 31, 'name' => 'Maluku'],
            ['id' => 32, 'name' => 'Maluku Utara'],
            ['id' => 33, 'name' => 'Papua Barat'],
            ['id' => 34, 'name' => 'Papua'],
        );
        DB::table('provinces')->insert($provinces);
    }
}
