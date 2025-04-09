<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'dokter',
                'username' => 'dokterr',
                'password' => bcrypt('dokter123'),
                'role' => 'dokter'
            ],

            [
                'name' => 'admin',
                'username' => 'adminn',
                'password' => bcrypt('admin123'),
                'role' => 'admin'
            ]
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
