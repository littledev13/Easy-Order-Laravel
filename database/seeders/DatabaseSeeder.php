<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('kategoris')->insert([
            [
                'nama' => 'makanan',
                'created_at' => now()
            ],
            [
                'nama' => 'minuman',
                'created_at' => now()
            ],
            [
                'name' => 'desert',
                'created_at' => now()
            ]
        ]);
        DB::table('levels')->insert(
            [
                [
                    'nama' => 'administrator',
                    'created_at' => now()
                ],
                [
                    'nama' => 'manager',
                    'created_at' => now()
                ],
                [
                    'nama' => 'kasir',
                    'created_at' => now()
                ],
                [
                    'nama' => 'koki',
                    'created_at' => now()
                ]
            ]
        );
        DB::table('users')->insert([
            'nama' => 'administrator',
            'username' => 'administrator',
            'level' => 'administrator',
            'password' => Hash::make('admin981'),
            'no_hp' => '082374095590',
            'id_toko' => '1',
            'created_at' => now()
        ]);
        DB::table('tokos')->insert([
            'nama' => 'administrator',
            'pemilik' => 'irvan azwardi',
            'deskripsi' => 'Super Administrator',
            'alamat' => 'Jl. jalan-jalan',
            'created_at' => now()
        ]);
    }
}