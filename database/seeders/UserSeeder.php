<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('@admin123'),
                'role' => 'admin',

            ],
            [
                'id' => 2,
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('@user123'),
                'role' => 'user',

            ],


        ]);
    }
}
