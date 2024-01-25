<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Syafiq Rizky Fauzi',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password')
            ],
        ];

        // Masukkan data ke dalam tabel 'users'
        DB::table('users')->insert($data);
    }
}
