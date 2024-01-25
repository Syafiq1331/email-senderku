<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AntrianSeeder extends Seeder
{
    public function run()
    {
        // Hapus data sebelumnya jika ada
        DB::table('antrian')->truncate();

        // Data seeder
        $data = [
            [
                'name' => 'Nama 1',
                'email' => 'bussinesyafiq@gmail.com',
                'keperluan' => 'Keperluan 1',
                'bukti_surat' => 'bukti_surat_1.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'menunggu',
            ],
            [
                'name' => 'Nama 2',
                'email' => 'rizkyfauzi8900@gmail.com',
                'keperluan' => 'Keperluan 2',
                'bukti_surat' => 'bukti_surat_2.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'diproses',
            ],
        ];

        // Insert data ke dalam tabel
        DB::table('antrian')->insert($data);
    }
}
