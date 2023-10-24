<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kandidat;
use App\Models\Kelas;
use App\Models\Pemilihan;
use App\Models\Peserta;
use App\Models\User;
use Carbon\Carbon;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make("123456"),
        ]);

        Kelas::insert([
            [
                'id_kelas' => 1,
                'nama_kelas' => "RPL 1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_kelas' => 2,
                'nama_kelas' => "RPL 2",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        Peserta::insert([
            [
                'id_peserta' => 1,
                'nama_peserta' => "Peserta 1",
                'tipe' => 1,
                'tingkatan' => 1,
                'id_kelas' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_peserta' => 2,
                'nama_peserta' => "Peserta 2",
                'tipe' => 1,
                'tingkatan' => 1,
                'id_kelas' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_peserta' => 3,
                'nama_peserta' => "Peserta 3",
                'tipe' => 1,
                'tingkatan' => 1,
                'id_kelas' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_peserta' => 4,
                'nama_peserta' => "Peserta 4",
                'tipe' => 1,
                'tingkatan' => 1,
                'id_kelas' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_peserta' => 5,
                'nama_peserta' => "Peserta 5",
                'tipe' => 1,
                'tingkatan' => 1,
                'id_kelas' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_peserta' => 6,
                'nama_peserta' => "Peserta 6",
                'tipe' => 1,
                'tingkatan' => 1,
                'id_kelas' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        Kandidat::insert([
            [
                'id_kandidat' => 1,
                'id_ketua' => 1,
                'id_wakil' => 2,
                'visi' => "Visi 1",
                'misi' => "Misi 1",
                'slogan' => "Slogan ",
                'foto' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_kandidat' => 2,
                'id_ketua' => 3,
                'id_wakil' => 4,
                'visi' => "Visi 2",
                'misi' => "Misi 2",
                'slogan' => "Slogan 2",
                'foto' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        Pemilihan::insert([
            [
                'id_pemilihan' => 1,
                'id_peserta' => 1,
                'id_kandidat' => 1,
                'waktu' => Carbon::now(),
                'longtitude' => null,
                'latitude' => null,
                'mac' => null,
                "status" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_pemilihan' => 2,
                'id_peserta' => 2,
                'id_kandidat' => 2,
                'waktu' => Carbon::now(),
                'longtitude' => null,
                'latitude' => null,
                'mac' => null,
                "status" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
