<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->delete();
        $cities = array(
            ['id' => 1, 'province_id' => 1, 'name' => 'Kab. Simeulue'],
            ['id' => 2, 'province_id' => 1, 'name' => 'Kab. Aceh Singkil'],
            ['id' => 3, 'province_id' => 1, 'name' => 'Kab. Aceh Selatan'],
            ['id' => 4, 'province_id' => 1, 'name' => 'Kab. Aceh Tenggara'],
            ['id' => 5, 'province_id' => 1, 'name' => 'Kab. Aceh Timur'],
            ['id' => 6, 'province_id' => 1, 'name' => 'Kab. Aceh Tengah'],
            ['id' => 7, 'province_id' => 1, 'name' => 'Kab. Aceh Barat'],
            ['id' => 8, 'province_id' => 1, 'name' => 'Kab. Aceh Besar'],
            ['id' => 9, 'province_id' => 1, 'name' => 'Kab. Pidie'],
            ['id' => 10, 'province_id' => 1, 'name' => 'Kab. Bireuen'],
            ['id' => 11, 'province_id' => 1, 'name' => 'Kab. Aceh Utara'],
            ['id' => 12, 'province_id' => 1, 'name' => 'Kab. Aceh Barat Daya'],
            ['id' => 13, 'province_id' => 1, 'name' => 'Kab. Gayo Lues'],
            ['id' => 14, 'province_id' => 1, 'name' => 'Kab. Aceh Tamiang'],
            ['id' => 15, 'province_id' => 1, 'name' => 'Kab. Nagan Raya'],
            ['id' => 16, 'province_id' => 1, 'name' => 'Kab. Aceh Jaya'],
            ['id' => 17, 'province_id' => 1, 'name' => 'Kab. Bener Meriah'],
            ['id' => 18, 'province_id' => 1, 'name' => 'Kab. Pidie Jaya'],
            ['id' => 19, 'province_id' => 1, 'name' => 'Kota Banda Aceh'],
            ['id' => 20, 'province_id' => 1, 'name' => 'Kota Sabang'],
            ['id' => 21, 'province_id' => 1, 'name' => 'Kota Langsa'],
            ['id' => 22, 'province_id' => 1, 'name' => 'Kota Lhokseumawe'],
            ['id' => 23, 'province_id' => 1, 'name' => 'Kota Subulussalam'],
            ['id' => 24, 'province_id' => 2, 'name' => 'Kab. Nias'],
            ['id' => 25, 'province_id' => 2, 'name' => 'Kab. Mandailing Natal'],
            ['id' => 26, 'province_id' => 2, 'name' => 'Kab. Tapanuli Selatan'],
            ['id' => 27, 'province_id' => 2, 'name' => 'Kab. Tapanuli Tengah'],
            ['id' => 28, 'province_id' => 2, 'name' => 'Kab. Tapanuli Utara'],
            ['id' => 29, 'province_id' => 2, 'name' => 'Kab. Toba Samosir'],
            ['id' => 30, 'province_id' => 2, 'name' => 'Kab. Labuhan Batu'],
            ['id' => 31, 'province_id' => 2, 'name' => 'Kab. Asahan'],
            ['id' => 32, 'province_id' => 2, 'name' => 'Kab. Simalungun'],
            ['id' => 33, 'province_id' => 2, 'name' => 'Kab. Dairi'],
            ['id' => 34, 'province_id' => 2, 'name' => 'Kab. Karo'],
            ['id' => 35, 'province_id' => 2, 'name' => 'Kab. Deli Serdang'],
            ['id' => 36, 'province_id' => 2, 'name' => 'Kab. Langkat'],
            ['id' => 37, 'province_id' => 2, 'name' => 'Kab. Nias Selatan'],
            ['id' => 38, 'province_id' => 2, 'name' => 'Kab. Humbang Hasundutan'],
            ['id' => 39, 'province_id' => 2, 'name' => 'Kab. Pakpak Bharat'],
            ['id' => 40, 'province_id' => 2, 'name' => 'Kab. Samosir'],
            ['id' => 41, 'province_id' => 2, 'name' => 'Kab. Serdang Bedagai'],
            ['id' => 42, 'province_id' => 2, 'name' => 'Kab. Batu Bara'],
            ['id' => 43, 'province_id' => 2, 'name' => 'Kab. Padang Lawas Utara'],
            ['id' => 44, 'province_id' => 2, 'name' => 'Kab. Padang Lawas'],
            ['id' => 45, 'province_id' => 2, 'name' => 'Kab. Labuhan Batu Selatan'],
            ['id' => 46, 'province_id' => 2, 'name' => 'Kab. Labuhan Batu Utara'],
            ['id' => 47, 'province_id' => 2, 'name' => 'Kab. Nias Utara'],
            ['id' => 48, 'province_id' => 2, 'name' => 'Kab. Nias Barat'],
            ['id' => 49, 'province_id' => 2, 'name' => 'Kota Sibolga'],
            ['id' => 50, 'province_id' => 2, 'name' => 'Kota Tanjung Balai'],
            ['id' => 51, 'province_id' => 2, 'name' => 'Kota Pematang Siantar'],
            ['id' => 52, 'province_id' => 2, 'name' => 'Kota Tebing Tinggi'],
            ['id' => 53, 'province_id' => 2, 'name' => 'Kota Medan'],
            ['id' => 54, 'province_id' => 2, 'name' => 'Kota Binjai'],
            ['id' => 55, 'province_id' => 2, 'name' => 'Kota Padangsidimpuan'],
            ['id' => 56, 'province_id' => 2, 'name' => 'Kota Gunungsitoli'],
            ['id' => 57, 'province_id' => 3, 'name' => 'Kab. Kepulauan Mentawai'],
            ['id' => 58, 'province_id' => 3, 'name' => 'Kab. Pesisir Selatan'],
            ['id' => 59, 'province_id' => 3, 'name' => 'Kab. Solok'],
            ['id' => 60, 'province_id' => 3, 'name' => 'Kab. Sijunjung'],
            ['id' => 61, 'province_id' => 3, 'name' => 'Kab. Tanah Datar'],
            ['id' => 62, 'province_id' => 3, 'name' => 'Kab. Padang Pariaman'],
            ['id' => 63, 'province_id' => 3, 'name' => 'Kab. Agam'],
            ['id' => 64, 'province_id' => 3, 'name' => 'Kab. Lima Puluh Kota'],
            ['id' => 65, 'province_id' => 3, 'name' => 'Kab. Pasaman'],
            ['id' => 66, 'province_id' => 3, 'name' => 'Kab. Solok Selatan'],
            ['id' => 67, 'province_id' => 3, 'name' => 'Kab. Dharmasraya'],
            ['id' => 68, 'province_id' => 3, 'name' => 'Kab. Pasaman Barat'],
            ['id' => 69, 'province_id' => 3, 'name' => 'Kota Padang'],
            ['id' => 70, 'province_id' => 3, 'name' => 'Kota Solok'],
            ['id' => 71, 'province_id' => 3, 'name' => 'Kota Sawah Lunto'],
            ['id' => 72, 'province_id' => 3, 'name' => 'Kota Padang Panjang'],
            ['id' => 73, 'province_id' => 3, 'name' => 'Kota Bukittinggi'],
            ['id' => 74, 'province_id' => 3, 'name' => 'Kota Payakumbuh'],
            ['id' => 75, 'province_id' => 3, 'name' => 'Kota Pariaman'],
            ['id' => 76, 'province_id' => 4, 'name' => 'Kab. Kuantan Singingi'],
            ['id' => 77, 'province_id' => 4, 'name' => 'Kab. Indragiri Hulu'],
            ['id' => 78, 'province_id' => 4, 'name' => 'Kab. Indragiri Hilir'],
            ['id' => 79, 'province_id' => 4, 'name' => 'Kab. Pelalawan'],
            ['id' => 80, 'province_id' => 4, 'name' => 'Kab. S I A K'],
            ['id' => 81, 'province_id' => 4, 'name' => 'Kab. Kampar'],
            ['id' => 82, 'province_id' => 4, 'name' => 'Kab. Rokan Hulu'],
            ['id' => 83, 'province_id' => 4, 'name' => 'Kab. Bengkalis'],
            ['id' => 84, 'province_id' => 4, 'name' => 'Kab. Rokan Hilir'],
            ['id' => 85, 'province_id' => 4, 'name' => 'Kab. Kepulauan Meranti'],
            ['id' => 86, 'province_id' => 4, 'name' => 'Kota Pekanbaru'],
            ['id' => 87, 'province_id' => 4, 'name' => 'Kota D U M A I'],
            ['id' => 88, 'province_id' => 5, 'name' => 'Kab. Kerinci'],
            ['id' => 89, 'province_id' => 5, 'name' => 'Kab. Merangin'],
            ['id' => 90, 'province_id' => 5, 'name' => 'Kab. Sarolangun'],
            ['id' => 91, 'province_id' => 5, 'name' => 'Kab. Batang Hari'],
            ['id' => 92, 'province_id' => 5, 'name' => 'Kab. Muaro Jambi'],
            ['id' => 93, 'province_id' => 5, 'name' => 'Kab. Tanjung Jabung Timur'],
            ['id' => 94, 'province_id' => 5, 'name' => 'Kab. Tanjung Jabung Barat'],
            ['id' => 95, 'province_id' => 5, 'name' => 'Kab. Tebo'],
            ['id' => 96, 'province_id' => 5, 'name' => 'Kab. Bungo'],
            ['id' => 97, 'province_id' => 5, 'name' => 'Kota Jambi'],
            ['id' => 98, 'province_id' => 5, 'name' => 'Kota Sungai Penuh'],
            ['id' => 99, 'province_id' => 6, 'name' => 'Kab. Ogan Komering Ulu'],
            ['id' => 100, 'province_id' => 6, 'name' => 'Kab. Ogan Komering Ilir'],
            ['id' => 101, 'province_id' => 6, 'name' => 'Kab. Muara Enim'],
            ['id' => 102, 'province_id' => 6, 'name' => 'Kab. Lahat'],
            ['id' => 103, 'province_id' => 6, 'name' => 'Kab. Musi Rawas'],
            ['id' => 104, 'province_id' => 6, 'name' => 'Kab. Musi Banyuasin'],
            ['id' => 105, 'province_id' => 6, 'name' => 'Kab. Banyu Asin'],
            ['id' => 106, 'province_id' => 6, 'name' => 'Kab. Ogan Komering Ulu Selatan'],
            ['id' => 107, 'province_id' => 6, 'name' => 'Kab. Ogan Komering Ulu Timur'],
            ['id' => 108, 'province_id' => 6, 'name' => 'Kab. Ogan Ilir'],
            ['id' => 109, 'province_id' => 6, 'name' => 'Kab. Empat Lawang'],
            ['id' => 110, 'province_id' => 6, 'name' => 'Kota Palembang'],
            ['id' => 111, 'province_id' => 6, 'name' => 'Kota Prabumulih'],
            ['id' => 112, 'province_id' => 6, 'name' => 'Kota Pagar Alam'],
            ['id' => 113, 'province_id' => 6, 'name' => 'Kota Lubuklinggau'],
            ['id' => 114, 'province_id' => 7, 'name' => 'Kab. Bengkulu Selatan'],
            ['id' => 115, 'province_id' => 7, 'name' => 'Kab. Rejang Lebong'],
            ['id' => 116, 'province_id' => 7, 'name' => 'Kab. Bengkulu Utara'],
            ['id' => 117, 'province_id' => 7, 'name' => 'Kab. Kaur'],
            ['id' => 118, 'province_id' => 7, 'name' => 'Kab. Seluma'],
            ['id' => 119, 'province_id' => 7, 'name' => 'Kab. Mukomuko'],
            ['id' => 120, 'province_id' => 7, 'name' => 'Kab. Lebong'],
            ['id' => 121, 'province_id' => 7, 'name' => 'Kab. Kepahiang'],
            ['id' => 122, 'province_id' => 7, 'name' => 'Kab. Bengkulu Tengah'],
            ['id' => 123, 'province_id' => 7, 'name' => 'Kota Bengkulu'],
            ['id' => 124, 'province_id' => 8, 'name' => 'Kab. Lampung Barat'],
            ['id' => 125, 'province_id' => 8, 'name' => 'Kab. Tanggamus'],
            ['id' => 126, 'province_id' => 8, 'name' => 'Kab. Lampung Selatan'],
            ['id' => 127, 'province_id' => 8, 'name' => 'Kab. Lampung Timur'],
            ['id' => 128, 'province_id' => 8, 'name' => 'Kab. Lampung Tengah'],
            ['id' => 129, 'province_id' => 8, 'name' => 'Kab. Lampung Utara'],
            ['id' => 130, 'province_id' => 8, 'name' => 'Kab. Way Kanan'],
            ['id' => 131, 'province_id' => 8, 'name' => 'Kab. Tulangbawang'],
            ['id' => 132, 'province_id' => 8, 'name' => 'Kab. Pesawaran'],
            ['id' => 133, 'province_id' => 8, 'name' => 'Kab. Pringsewu'],
            ['id' => 134, 'province_id' => 8, 'name' => 'Kab. Mesuji'],
            ['id' => 135, 'province_id' => 8, 'name' => 'Kab. Tulang Bawang Barat'],
            ['id' => 136, 'province_id' => 8, 'name' => 'Kab. Pesisir Barat'],
            ['id' => 137, 'province_id' => 8, 'name' => 'Kota Bandar Lampung'],
            ['id' => 138, 'province_id' => 8, 'name' => 'Kota Metro'],
            ['id' => 139, 'province_id' => 9, 'name' => 'Kab. Bangka'],
            ['id' => 140, 'province_id' => 9, 'name' => 'Kab. Belitung'],
            ['id' => 141, 'province_id' => 9, 'name' => 'Kab. Bangka Barat'],
            ['id' => 142, 'province_id' => 9, 'name' => 'Kab. Bangka Tengah'],
            ['id' => 143, 'province_id' => 9, 'name' => 'Kab. Bangka Selatan'],
            ['id' => 144, 'province_id' => 9, 'name' => 'Kab. Belitung Timur'],
            ['id' => 145, 'province_id' => 9, 'name' => 'Kota Pangkal Pinang'],
            ['id' => 146, 'province_id' => 10, 'name' => 'Kab. Karimun'],
            ['id' => 147, 'province_id' => 10, 'name' => 'Kab. Bintan'],
            ['id' => 148, 'province_id' => 10, 'name' => 'Kab. Natuna'],
            ['id' => 149, 'province_id' => 10, 'name' => 'Kab. Lingga'],
            ['id' => 150, 'province_id' => 10, 'name' => 'Kab. Kepulauan Anambas'],
            ['id' => 151, 'province_id' => 10, 'name' => 'Kota B A T A M'],
            ['id' => 152, 'province_id' => 10, 'name' => 'Kota Tanjung Pinang'],
            ['id' => 153, 'province_id' => 11, 'name' => 'Kab. Kepulauan Seribu'],
            ['id' => 154, 'province_id' => 11, 'name' => 'Kota Jakarta Selatan'],
            ['id' => 155, 'province_id' => 11, 'name' => 'Kota Jakarta Timur'],
            ['id' => 156, 'province_id' => 11, 'name' => 'Kota Jakarta Pusat'],
            ['id' => 157, 'province_id' => 11, 'name' => 'Kota Jakarta Barat'],
            ['id' => 158, 'province_id' => 11, 'name' => 'Kota Jakarta Utara'],
            ['id' => 159, 'province_id' => 12, 'name' => 'Kab. Bogor'],
            ['id' => 160, 'province_id' => 12, 'name' => 'Kab. Sukabumi'],
            ['id' => 161, 'province_id' => 12, 'name' => 'Kab. Cianjur'],
            ['id' => 162, 'province_id' => 12, 'name' => 'Kab. Bandung'],
            ['id' => 163, 'province_id' => 12, 'name' => 'Kab. Garut'],
            ['id' => 164, 'province_id' => 12, 'name' => 'Kab. Tasikmalaya'],
            ['id' => 165, 'province_id' => 12, 'name' => 'Kab. Ciamis'],
            ['id' => 166, 'province_id' => 12, 'name' => 'Kab. Kuningan'],
            ['id' => 167, 'province_id' => 12, 'name' => 'Kab. Cirebon'],
            ['id' => 168, 'province_id' => 12, 'name' => 'Kab. Majalengka'],
            ['id' => 169, 'province_id' => 12, 'name' => 'Kab. Sumedang'],
            ['id' => 170, 'province_id' => 12, 'name' => 'Kab. Indramayu'],
            ['id' => 171, 'province_id' => 12, 'name' => 'Kab. Subang'],
            ['id' => 172, 'province_id' => 12, 'name' => 'Kab. Purwakarta'],
            ['id' => 173, 'province_id' => 12, 'name' => 'Kab. Karawang'],
            ['id' => 174, 'province_id' => 12, 'name' => 'Kab. Bekasi'],
            ['id' => 175, 'province_id' => 12, 'name' => 'Kab. Bandung Barat'],
            ['id' => 176, 'province_id' => 12, 'name' => 'Kab. Pangandaran'],
            ['id' => 177, 'province_id' => 12, 'name' => 'Kota Bogor'],
            ['id' => 178, 'province_id' => 12, 'name' => 'Kota Sukabumi'],
            ['id' => 179, 'province_id' => 12, 'name' => 'Kota Bandung'],
            ['id' => 180, 'province_id' => 12, 'name' => 'Kota Cirebon'],
            ['id' => 181, 'province_id' => 12, 'name' => 'Kota Bekasi'],
            ['id' => 182, 'province_id' => 12, 'name' => 'Kota Depok'],
            ['id' => 183, 'province_id' => 12, 'name' => 'Kota Cimahi'],
            ['id' => 184, 'province_id' => 12, 'name' => 'Kota Tasikmalaya'],
            ['id' => 185, 'province_id' => 12, 'name' => 'Kota Banjar'],
            ['id' => 186, 'province_id' => 13, 'name' => 'Kab. Cilacap'],
            ['id' => 187, 'province_id' => 13, 'name' => 'Kab. Banyumas'],
            ['id' => 188, 'province_id' => 13, 'name' => 'Kab. Purbalingga'],
            ['id' => 189, 'province_id' => 13, 'name' => 'Kab. Banjarnegara'],
            ['id' => 190, 'province_id' => 13, 'name' => 'Kab. Kebumen'],
            ['id' => 191, 'province_id' => 13, 'name' => 'Kab. Purworejo'],
            ['id' => 192, 'province_id' => 13, 'name' => 'Kab. Wonosobo'],
            ['id' => 193, 'province_id' => 13, 'name' => 'Kab. Magelang'],
            ['id' => 194, 'province_id' => 13, 'name' => 'Kab. Boyolali'],
            ['id' => 195, 'province_id' => 13, 'name' => 'Kab. Klaten'],
            ['id' => 196, 'province_id' => 13, 'name' => 'Kab. Sukoharjo'],
            ['id' => 197, 'province_id' => 13, 'name' => 'Kab. Wonogiri'],
            ['id' => 198, 'province_id' => 13, 'name' => 'Kab. Karanganyar'],
            ['id' => 199, 'province_id' => 13, 'name' => 'Kab. Sragen'],
            ['id' => 200, 'province_id' => 13, 'name' => 'Kab. Grobogan'],
            ['id' => 201, 'province_id' => 13, 'name' => 'Kab. Blora'],
            ['id' => 202, 'province_id' => 13, 'name' => 'Kab. Rembang'],
            ['id' => 203, 'province_id' => 13, 'name' => 'Kab. Pati'],
            ['id' => 204, 'province_id' => 13, 'name' => 'Kab. Kudus'],
            ['id' => 205, 'province_id' => 13, 'name' => 'Kab. Jepara'],
            ['id' => 206, 'province_id' => 13, 'name' => 'Kab. Demak'],
            ['id' => 207, 'province_id' => 13, 'name' => 'Kab. Semarang'],
            ['id' => 208, 'province_id' => 13, 'name' => 'Kab. Temanggung'],
            ['id' => 209, 'province_id' => 13, 'name' => 'Kab. Kendal'],
            ['id' => 210, 'province_id' => 13, 'name' => 'Kab. Batang'],
            ['id' => 211, 'province_id' => 13, 'name' => 'Kab. Pekalongan'],
            ['id' => 212, 'province_id' => 13, 'name' => 'Kab. Pemalang'],
            ['id' => 213, 'province_id' => 13, 'name' => 'Kab. Tegal'],
            ['id' => 214, 'province_id' => 13, 'name' => 'Kab. Brebes'],
            ['id' => 215, 'province_id' => 13, 'name' => 'Kota Magelang'],
            ['id' => 216, 'province_id' => 13, 'name' => 'Kota Surakarta'],
            ['id' => 217, 'province_id' => 13, 'name' => 'Kota Salatiga'],
            ['id' => 218, 'province_id' => 13, 'name' => 'Kota Semarang'],
            ['id' => 219, 'province_id' => 13, 'name' => 'Kota Pekalongan'],
            ['id' => 220, 'province_id' => 13, 'name' => 'Kota Tegal'],
            ['id' => 221, 'province_id' => 14, 'name' => 'Kab. Kulon Progo'],
            ['id' => 222, 'province_id' => 14, 'name' => 'Kab. Bantul'],
            ['id' => 223, 'province_id' => 14, 'name' => 'Kab. Gunung Kidul'],
            ['id' => 224, 'province_id' => 14, 'name' => 'Kab. Sleman'],
            ['id' => 225, 'province_id' => 14, 'name' => 'Kota Yogyakarta'],
            ['id' => 226, 'province_id' => 15, 'name' => 'Kab. Pacitan'],
            ['id' => 227, 'province_id' => 15, 'name' => 'Kab. Ponorogo'],
            ['id' => 228, 'province_id' => 15, 'name' => 'Kab. Trenggalek'],
            ['id' => 229, 'province_id' => 15, 'name' => 'Kab. Tulungagung'],
            ['id' => 230, 'province_id' => 15, 'name' => 'Kab. Blitar'],
            ['id' => 231, 'province_id' => 15, 'name' => 'Kab. Kediri'],
            ['id' => 232, 'province_id' => 15, 'name' => 'Kab. Malang'],
            ['id' => 233, 'province_id' => 15, 'name' => 'Kab. Lumajang'],
            ['id' => 234, 'province_id' => 15, 'name' => 'Kab. Jember'],
            ['id' => 235, 'province_id' => 15, 'name' => 'Kab. Banyuwangi'],
            ['id' => 236, 'province_id' => 15, 'name' => 'Kab. Bondowoso'],
            ['id' => 237, 'province_id' => 15, 'name' => 'Kab. Situbondo'],
            ['id' => 238, 'province_id' => 15, 'name' => 'Kab. Probolinggo'],
            ['id' => 239, 'province_id' => 15, 'name' => 'Kab. Pasuruan'],
            ['id' => 240, 'province_id' => 15, 'name' => 'Kab. Sidoarjo'],
            ['id' => 241, 'province_id' => 15, 'name' => 'Kab. Mojokerto'],
            ['id' => 242, 'province_id' => 15, 'name' => 'Kab. Jombang'],
            ['id' => 243, 'province_id' => 15, 'name' => 'Kab. Nganjuk'],
            ['id' => 244, 'province_id' => 15, 'name' => 'Kab. Madiun'],
            ['id' => 245, 'province_id' => 15, 'name' => 'Kab. Magetan'],
            ['id' => 246, 'province_id' => 15, 'name' => 'Kab. Ngawi'],
            ['id' => 247, 'province_id' => 15, 'name' => 'Kab. Bojonegoro'],
            ['id' => 248, 'province_id' => 15, 'name' => 'Kab. Tuban'],
            ['id' => 249, 'province_id' => 15, 'name' => 'Kab. Lamongan'],
            ['id' => 250, 'province_id' => 15, 'name' => 'Kab. Gresik'],
            ['id' => 251, 'province_id' => 15, 'name' => 'Kab. Bangkalan'],
            ['id' => 252, 'province_id' => 15, 'name' => 'Kab. Sampang'],
            ['id' => 253, 'province_id' => 15, 'name' => 'Kab. Pamekasan'],
            ['id' => 254, 'province_id' => 15, 'name' => 'Kab. Sumenep'],
            ['id' => 255, 'province_id' => 15, 'name' => 'Kota Kediri'],
            ['id' => 256, 'province_id' => 15, 'name' => 'Kota Blitar'],
            ['id' => 257, 'province_id' => 15, 'name' => 'Kota Malang'],
            ['id' => 258, 'province_id' => 15, 'name' => 'Kota Probolinggo'],
            ['id' => 259, 'province_id' => 15, 'name' => 'Kota Pasuruan'],
            ['id' => 260, 'province_id' => 15, 'name' => 'Kota Mojokerto'],
            ['id' => 261, 'province_id' => 15, 'name' => 'Kota Madiun'],
            ['id' => 262, 'province_id' => 15, 'name' => 'Kota Surabaya'],
            ['id' => 263, 'province_id' => 15, 'name' => 'Kota Batu'],
            ['id' => 264, 'province_id' => 16, 'name' => 'Kab. Pandeglang'],
            ['id' => 265, 'province_id' => 16, 'name' => 'Kab. Lebak'],
            ['id' => 266, 'province_id' => 16, 'name' => 'Kab. Tangerang'],
            ['id' => 267, 'province_id' => 16, 'name' => 'Kab. Serang'],
            ['id' => 268, 'province_id' => 16, 'name' => 'Kota Tangerang'],
            ['id' => 269, 'province_id' => 16, 'name' => 'Kota Cilegon'],
            ['id' => 270, 'province_id' => 16, 'name' => 'Kota Serang'],
            ['id' => 271, 'province_id' => 16, 'name' => 'Kota Tangerang Selatan'],
            ['id' => 272, 'province_id' => 17, 'name' => 'Kab. Jembrana'],
            ['id' => 273, 'province_id' => 17, 'name' => 'Kab. Tabanan'],
            ['id' => 274, 'province_id' => 17, 'name' => 'Kab. Badung'],
            ['id' => 275, 'province_id' => 17, 'name' => 'Kab. Gianyar'],
            ['id' => 276, 'province_id' => 17, 'name' => 'Kab. Klungkung'],
            ['id' => 277, 'province_id' => 17, 'name' => 'Kab. Bangli'],
            ['id' => 278, 'province_id' => 17, 'name' => 'Kab. Karang Asem'],
            ['id' => 279, 'province_id' => 17, 'name' => 'Kab. Buleleng'],
            ['id' => 280, 'province_id' => 17, 'name' => 'Kota Denpasar'],
            ['id' => 281, 'province_id' => 18, 'name' => 'Kab. Lombok Barat'],
            ['id' => 282, 'province_id' => 18, 'name' => 'Kab. Lombok Tengah'],
            ['id' => 283, 'province_id' => 18, 'name' => 'Kab. Lombok Timur'],
            ['id' => 284, 'province_id' => 18, 'name' => 'Kab. Sumbawa'],
            ['id' => 285, 'province_id' => 18, 'name' => 'Kab. Dompu'],
            ['id' => 286, 'province_id' => 18, 'name' => 'Kab. Bima'],
            ['id' => 287, 'province_id' => 18, 'name' => 'Kab. Sumbawa Barat'],
            ['id' => 288, 'province_id' => 18, 'name' => 'Kab. Lombok Utara'],
            ['id' => 289, 'province_id' => 18, 'name' => 'Kota Mataram'],
            ['id' => 290, 'province_id' => 18, 'name' => 'Kota Bima'],
            ['id' => 291, 'province_id' => 19, 'name' => 'Kab. Sumba Barat'],
            ['id' => 292, 'province_id' => 19, 'name' => 'Kab. Sumba Timur'],
            ['id' => 293, 'province_id' => 19, 'name' => 'Kab. Kupang'],
            ['id' => 294, 'province_id' => 19, 'name' => 'Kab. Timor Tengah Selatan'],
            ['id' => 295, 'province_id' => 19, 'name' => 'Kab. Timor Tengah Utara'],
            ['id' => 296, 'province_id' => 19, 'name' => 'Kab. Belu'],
            ['id' => 297, 'province_id' => 19, 'name' => 'Kab. Alor'],
            ['id' => 298, 'province_id' => 19, 'name' => 'Kab. Lembata'],
            ['id' => 299, 'province_id' => 19, 'name' => 'Kab. Flores Timur'],
            ['id' => 300, 'province_id' => 19, 'name' => 'Kab. Sikka'],
            ['id' => 301, 'province_id' => 19, 'name' => 'Kab. Ende'],
            ['id' => 302, 'province_id' => 19, 'name' => 'Kab. Ngada'],
            ['id' => 303, 'province_id' => 19, 'name' => 'Kab. Manggarai'],
            ['id' => 304, 'province_id' => 19, 'name' => 'Kab. Rote Ndao'],
            ['id' => 305, 'province_id' => 19, 'name' => 'Kab. Manggarai Barat'],
            ['id' => 306, 'province_id' => 19, 'name' => 'Kab. Sumba Tengah'],
            ['id' => 307, 'province_id' => 19, 'name' => 'Kab. Sumba Barat Daya'],
            ['id' => 308, 'province_id' => 19, 'name' => 'Kab. Nagekeo'],
            ['id' => 309, 'province_id' => 19, 'name' => 'Kab. Manggarai Timur'],
            ['id' => 310, 'province_id' => 19, 'name' => 'Kab. Sabu Raijua'],
            ['id' => 311, 'province_id' => 19, 'name' => 'Kota Kupang'],
            ['id' => 312, 'province_id' => 20, 'name' => 'Kab. Sambas'],
            ['id' => 313, 'province_id' => 20, 'name' => 'Kab. Bengkayang'],
            ['id' => 314, 'province_id' => 20, 'name' => 'Kab. Landak'],
            ['id' => 315, 'province_id' => 20, 'name' => 'Kab. Pontianak'],
            ['id' => 316, 'province_id' => 20, 'name' => 'Kab. Sanggau'],
            ['id' => 317, 'province_id' => 20, 'name' => 'Kab. Ketapang'],
            ['id' => 318, 'province_id' => 20, 'name' => 'Kab. Sintang'],
            ['id' => 319, 'province_id' => 20, 'name' => 'Kab. Kapuas Hulu'],
            ['id' => 320, 'province_id' => 20, 'name' => 'Kab. Sekadau'],
            ['id' => 321, 'province_id' => 20, 'name' => 'Kab. Melawi'],
            ['id' => 322, 'province_id' => 20, 'name' => 'Kab. Kayong Utara'],
            ['id' => 323, 'province_id' => 20, 'name' => 'Kab. Kubu Raya'],
            ['id' => 324, 'province_id' => 20, 'name' => 'Kota Pontianak'],
            ['id' => 325, 'province_id' => 20, 'name' => 'Kota Singkawang'],
            ['id' => 326, 'province_id' => 21, 'name' => 'Kab. Kotawaringin Barat'],
            ['id' => 327, 'province_id' => 21, 'name' => 'Kab. Kotawaringin Timur'],
            ['id' => 328, 'province_id' => 21, 'name' => 'Kab. Kapuas'],
            ['id' => 329, 'province_id' => 21, 'name' => 'Kab. Barito Selatan'],
            ['id' => 330, 'province_id' => 21, 'name' => 'Kab. Barito Utara'],
            ['id' => 331, 'province_id' => 21, 'name' => 'Kab. Sukamara'],
            ['id' => 332, 'province_id' => 21, 'name' => 'Kab. Lamandau'],
            ['id' => 333, 'province_id' => 21, 'name' => 'Kab. Seruyan'],
            ['id' => 334, 'province_id' => 21, 'name' => 'Kab. Katingan'],
            ['id' => 335, 'province_id' => 21, 'name' => 'Kab. Pulang Pisau'],
            ['id' => 336, 'province_id' => 21, 'name' => 'Kab. Gunung Mas'],
            ['id' => 337, 'province_id' => 21, 'name' => 'Kab. Barito Timur'],
            ['id' => 338, 'province_id' => 21, 'name' => 'Kab. Murung Raya'],
            ['id' => 339, 'province_id' => 21, 'name' => 'Kota Palangka Raya'],
            ['id' => 340, 'province_id' => 22, 'name' => 'Kab. Tanah Laut'],
            ['id' => 341, 'province_id' => 22, 'name' => 'Kab. Kota Baru'],
            ['id' => 342, 'province_id' => 22, 'name' => 'Kab. Banjar'],
            ['id' => 343, 'province_id' => 22, 'name' => 'Kab. Barito Kuala'],
            ['id' => 344, 'province_id' => 22, 'name' => 'Kab. Tapin'],
            ['id' => 345, 'province_id' => 22, 'name' => 'Kab. Hulu Sungai Selatan'],
            ['id' => 346, 'province_id' => 22, 'name' => 'Kab. Hulu Sungai Tengah'],
            ['id' => 347, 'province_id' => 22, 'name' => 'Kab. Hulu Sungai Utara'],
            ['id' => 348, 'province_id' => 22, 'name' => 'Kab. Tabalong'],
            ['id' => 349, 'province_id' => 22, 'name' => 'Kab. Tanah Bumbu'],
            ['id' => 350, 'province_id' => 22, 'name' => 'Kab. Balangan'],
            ['id' => 351, 'province_id' => 22, 'name' => 'Kota Banjarmasin'],
            ['id' => 352, 'province_id' => 22, 'name' => 'Kota Banjar Baru'],
            ['id' => 353, 'province_id' => 23, 'name' => 'Kab. Paser'],
            ['id' => 354, 'province_id' => 23, 'name' => 'Kab. Kutai Barat'],
            ['id' => 355, 'province_id' => 23, 'name' => 'Kab. Kutai Kartanegara'],
            ['id' => 356, 'province_id' => 23, 'name' => 'Kab. Kutai Timur'],
            ['id' => 357, 'province_id' => 23, 'name' => 'Kab. Berau'],
            ['id' => 358, 'province_id' => 23, 'name' => 'Kab. Penajam Paser Utara'],
            ['id' => 359, 'province_id' => 23, 'name' => 'Kota Balikpapan'],
            ['id' => 360, 'province_id' => 23, 'name' => 'Kota Samarinda'],
            ['id' => 361, 'province_id' => 23, 'name' => 'Kota Bontang'],
            ['id' => 362, 'province_id' => 24, 'name' => 'Kab. Malinau'],
            ['id' => 363, 'province_id' => 24, 'name' => 'Kab. Bulungan'],
            ['id' => 364, 'province_id' => 24, 'name' => 'Kab. Tana Tidung'],
            ['id' => 365, 'province_id' => 24, 'name' => 'Kab. Nunukan'],
            ['id' => 366, 'province_id' => 24, 'name' => 'Kota Tarakan'],
            ['id' => 367, 'province_id' => 25, 'name' => 'Kab. Bolaang Mongondow'],
            ['id' => 368, 'province_id' => 25, 'name' => 'Kab. Minahasa'],
            ['id' => 369, 'province_id' => 25, 'name' => 'Kab. Kepulauan Sangihe'],
            ['id' => 370, 'province_id' => 25, 'name' => 'Kab. Kepulauan Talaud'],
            ['id' => 371, 'province_id' => 25, 'name' => 'Kab. Minahasa Selatan'],
            ['id' => 372, 'province_id' => 25, 'name' => 'Kab. Minahasa Utara'],
            ['id' => 373, 'province_id' => 25, 'name' => 'Kab. Bolaang Mongondow Utara'],
            ['id' => 374, 'province_id' => 25, 'name' => 'Kab. Siau Tagulandang Biaro'],
            ['id' => 375, 'province_id' => 25, 'name' => 'Kab. Minahasa Tenggara'],
            ['id' => 376, 'province_id' => 25, 'name' => 'Kab. Bolaang Mongondow Selatan'],
            ['id' => 377, 'province_id' => 25, 'name' => 'Kab. Bolaang Mongondow Timur'],
            ['id' => 378, 'province_id' => 25, 'name' => 'Kota Manado'],
            ['id' => 379, 'province_id' => 25, 'name' => 'Kota Bitung'],
            ['id' => 380, 'province_id' => 25, 'name' => 'Kota Tomohon'],
            ['id' => 381, 'province_id' => 25, 'name' => 'Kota Kotamobagu'],
            ['id' => 382, 'province_id' => 26, 'name' => 'Kab. Banggai Kepulauan'],
            ['id' => 383, 'province_id' => 26, 'name' => 'Kab. Banggai'],
            ['id' => 384, 'province_id' => 26, 'name' => 'Kab. Morowali'],
            ['id' => 385, 'province_id' => 26, 'name' => 'Kab. Poso'],
            ['id' => 386, 'province_id' => 26, 'name' => 'Kab. Donggala'],
            ['id' => 387, 'province_id' => 26, 'name' => 'Kab. Toli-toli'],
            ['id' => 388, 'province_id' => 26, 'name' => 'Kab. Buol'],
            ['id' => 389, 'province_id' => 26, 'name' => 'Kab. Parigi Moutong'],
            ['id' => 390, 'province_id' => 26, 'name' => 'Kab. Tojo Una-una'],
            ['id' => 391, 'province_id' => 26, 'name' => 'Kab. Sigi'],
            ['id' => 392, 'province_id' => 26, 'name' => 'Kota Palu'],
            ['id' => 393, 'province_id' => 27, 'name' => 'Kab. Kepulauan Selayar'],
            ['id' => 394, 'province_id' => 27, 'name' => 'Kab. Bulukumba'],
            ['id' => 395, 'province_id' => 27, 'name' => 'Kab. Bantaeng'],
            ['id' => 396, 'province_id' => 27, 'name' => 'Kab. Jeneponto'],
            ['id' => 397, 'province_id' => 27, 'name' => 'Kab. Takalar'],
            ['id' => 398, 'province_id' => 27, 'name' => 'Kab. Gowa'],
            ['id' => 399, 'province_id' => 27, 'name' => 'Kab. Sinjai'],
            ['id' => 400, 'province_id' => 27, 'name' => 'Kab. Maros'],
            ['id' => 401, 'province_id' => 27, 'name' => 'Kab. Pangkajene Dan Kepulauan'],
            ['id' => 402, 'province_id' => 27, 'name' => 'Kab. Barru'],
            ['id' => 403, 'province_id' => 27, 'name' => 'Kab. Bone'],
            ['id' => 404, 'province_id' => 27, 'name' => 'Kab. Soppeng'],
            ['id' => 405, 'province_id' => 27, 'name' => 'Kab. Wajo'],
            ['id' => 406, 'province_id' => 27, 'name' => 'Kab. Sidenreng Rappang'],
            ['id' => 407, 'province_id' => 27, 'name' => 'Kab. Pinrang'],
            ['id' => 408, 'province_id' => 27, 'name' => 'Kab. Enrekang'],
            ['id' => 409, 'province_id' => 27, 'name' => 'Kab. Luwu'],
            ['id' => 410, 'province_id' => 27, 'name' => 'Kab. Tana Toraja'],
            ['id' => 411, 'province_id' => 27, 'name' => 'Kab. Luwu Utara'],
            ['id' => 412, 'province_id' => 27, 'name' => 'Kab. Luwu Timur'],
            ['id' => 413, 'province_id' => 27, 'name' => 'Kab. Toraja Utara'],
            ['id' => 414, 'province_id' => 27, 'name' => 'Kota Makassar'],
            ['id' => 415, 'province_id' => 27, 'name' => 'Kota Parepare'],
            ['id' => 416, 'province_id' => 27, 'name' => 'Kota Palopo'],
            ['id' => 417, 'province_id' => 28, 'name' => 'Kab. Buton'],
            ['id' => 418, 'province_id' => 28, 'name' => 'Kab. Muna'],
            ['id' => 419, 'province_id' => 28, 'name' => 'Kab. Konawe'],
            ['id' => 420, 'province_id' => 28, 'name' => 'Kab. Kolaka'],
            ['id' => 421, 'province_id' => 28, 'name' => 'Kab. Konawe Selatan'],
            ['id' => 422, 'province_id' => 28, 'name' => 'Kab. Bombana'],
            ['id' => 423, 'province_id' => 28, 'name' => 'Kab. Wakatobi'],
            ['id' => 424, 'province_id' => 28, 'name' => 'Kab. Kolaka Utara'],
            ['id' => 425, 'province_id' => 28, 'name' => 'Kab. Buton Utara'],
            ['id' => 426, 'province_id' => 28, 'name' => 'Kab. Konawe Utara'],
            ['id' => 427, 'province_id' => 28, 'name' => 'Kota Kendari'],
            ['id' => 428, 'province_id' => 28, 'name' => 'Kota Baubau'],
            ['id' => 429, 'province_id' => 29, 'name' => 'Kab. Boalemo'],
            ['id' => 430, 'province_id' => 29, 'name' => 'Kab. Gorontalo'],
            ['id' => 431, 'province_id' => 29, 'name' => 'Kab. Pohuwato'],
            ['id' => 432, 'province_id' => 29, 'name' => 'Kab. Bone Bolango'],
            ['id' => 433, 'province_id' => 29, 'name' => 'Kab. Gorontalo Utara'],
            ['id' => 434, 'province_id' => 29, 'name' => 'Kota Gorontalo'],
            ['id' => 435, 'province_id' => 30, 'name' => 'Kab. Majene'],
            ['id' => 436, 'province_id' => 30, 'name' => 'Kab. Polewali Mandar'],
            ['id' => 437, 'province_id' => 30, 'name' => 'Kab. Mamasa'],
            ['id' => 438, 'province_id' => 30, 'name' => 'Kab. Mamuju'],
            ['id' => 439, 'province_id' => 30, 'name' => 'Kab. Mamuju Utara'],
            ['id' => 440, 'province_id' => 31, 'name' => 'Kab. Maluku Tenggara Barat'],
            ['id' => 441, 'province_id' => 31, 'name' => 'Kab. Maluku Tenggara'],
            ['id' => 442, 'province_id' => 31, 'name' => 'Kab. Maluku Tengah'],
            ['id' => 443, 'province_id' => 31, 'name' => 'Kab. Buru'],
            ['id' => 444, 'province_id' => 31, 'name' => 'Kab. Kepulauan Aru'],
            ['id' => 445, 'province_id' => 31, 'name' => 'Kab. Seram Bagian Barat'],
            ['id' => 446, 'province_id' => 31, 'name' => 'Kab. Seram Bagian Timur'],
            ['id' => 447, 'province_id' => 31, 'name' => 'Kab. Maluku Barat Daya'],
            ['id' => 448, 'province_id' => 31, 'name' => 'Kab. Buru Selatan'],
            ['id' => 449, 'province_id' => 31, 'name' => 'Kota Ambon'],
            ['id' => 450, 'province_id' => 31, 'name' => 'Kota Tual'],
            ['id' => 451, 'province_id' => 32, 'name' => 'Kab. Halmahera Barat'],
            ['id' => 452, 'province_id' => 32, 'name' => 'Kab. Halmahera Tengah'],
            ['id' => 453, 'province_id' => 32, 'name' => 'Kab. Kepulauan Sula'],
            ['id' => 454, 'province_id' => 32, 'name' => 'Kab. Halmahera Selatan'],
            ['id' => 455, 'province_id' => 32, 'name' => 'Kab. Halmahera Utara'],
            ['id' => 456, 'province_id' => 32, 'name' => 'Kab. Halmahera Timur'],
            ['id' => 457, 'province_id' => 32, 'name' => 'Kab. Pulau Morotai'],
            ['id' => 458, 'province_id' => 32, 'name' => 'Kota Ternate'],
            ['id' => 459, 'province_id' => 32, 'name' => 'Kota Tidore Kepulauan'],
            ['id' => 460, 'province_id' => 33, 'name' => 'Kab. Fakfak'],
            ['id' => 461, 'province_id' => 33, 'name' => 'Kab. Kaimana'],
            ['id' => 462, 'province_id' => 33, 'name' => 'Kab. Teluk Wondama'],
            ['id' => 463, 'province_id' => 33, 'name' => 'Kab. Teluk Bintuni'],
            ['id' => 464, 'province_id' => 33, 'name' => 'Kab. Manokwari'],
            ['id' => 465, 'province_id' => 33, 'name' => 'Kab. Sorong Selatan'],
            ['id' => 466, 'province_id' => 33, 'name' => 'Kab. Sorong'],
            ['id' => 467, 'province_id' => 33, 'name' => 'Kab. Raja Ampat'],
            ['id' => 468, 'province_id' => 33, 'name' => 'Kab. Tambrauw'],
            ['id' => 469, 'province_id' => 33, 'name' => 'Kab. Maybrat'],
            ['id' => 470, 'province_id' => 33, 'name' => 'Kota Sorong'],
            ['id' => 471, 'province_id' => 34, 'name' => 'Kab. Merauke'],
            ['id' => 472, 'province_id' => 34, 'name' => 'Kab. Jayawijaya'],
            ['id' => 473, 'province_id' => 34, 'name' => 'Kab. Jayapura'],
            ['id' => 474, 'province_id' => 34, 'name' => 'Kab. Nabire'],
            ['id' => 475, 'province_id' => 34, 'name' => 'Kab. Kepulauan Yapen'],
            ['id' => 476, 'province_id' => 34, 'name' => 'Kab. Biak Numfor'],
            ['id' => 477, 'province_id' => 34, 'name' => 'Kab. Paniai'],
            ['id' => 478, 'province_id' => 34, 'name' => 'Kab. Puncak Jaya'],
            ['id' => 479, 'province_id' => 34, 'name' => 'Kab. Mimika'],
            ['id' => 480, 'province_id' => 34, 'name' => 'Kab. Boven Digoel'],
            ['id' => 481, 'province_id' => 34, 'name' => 'Kab. Mappi'],
            ['id' => 482, 'province_id' => 34, 'name' => 'Kab. Asmat'],
            ['id' => 483, 'province_id' => 34, 'name' => 'Kab. Yahukimo'],
            ['id' => 484, 'province_id' => 34, 'name' => 'Kab. Pegunungan Bintang'],
            ['id' => 485, 'province_id' => 34, 'name' => 'Kab. Tolikara'],
            ['id' => 486, 'province_id' => 34, 'name' => 'Kab. Sarmi'],
            ['id' => 487, 'province_id' => 34, 'name' => 'Kab. Keerom'],
            ['id' => 488, 'province_id' => 34, 'name' => 'Kab. Waropen'],
            ['id' => 489, 'province_id' => 34, 'name' => 'Kab. Supiori'],
            ['id' => 490, 'province_id' => 34, 'name' => 'Kab. Mamberamo Raya'],
            ['id' => 491, 'province_id' => 34, 'name' => 'Kab. Nduga'],
            ['id' => 492, 'province_id' => 34, 'name' => 'Kab. Lanny Jaya'],
            ['id' => 493, 'province_id' => 34, 'name' => 'Kab. Mamberamo Tengah'],
            ['id' => 494, 'province_id' => 34, 'name' => 'Kab. Yalimo'],
            ['id' => 495, 'province_id' => 34, 'name' => 'Kab. Puncak'],
            ['id' => 496, 'province_id' => 34, 'name' => 'Kab. Dogiyai'],
            ['id' => 497, 'province_id' => 34, 'name' => 'Kab. Intan Jaya'],
            ['id' => 498, 'province_id' => 34, 'name' => 'Kab. Deiyai'],
            ['id' => 499, 'province_id' => 34, 'name' => 'Kota Jayapura'],
        );
        DB::table('cities')->insert($cities);
    }
}
