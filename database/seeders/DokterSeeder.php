<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB; // Menggunakan DB facade untuk query langsung

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID user dengan username 'dokterr' dari tabel users
        $dokterUser = DB::table('users')->where('username', 'dokterr')->first();

        if ($dokterUser) {
            $DoctorData = [
                [
                    'nama' => 'Dr. Erlyn Aprilia',
                    'user_id' => $dokterUser->id, // Hubungkan dengan ID user dokter
                ],
            ];

            foreach ($DoctorData as $key => $val) {
                Doctor::create($val);
            }
        }
    }
}
