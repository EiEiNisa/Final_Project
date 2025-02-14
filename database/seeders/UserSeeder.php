<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $fakerTH = Faker::create('th_TH'); 
        $fakerEN = Faker::create('en_US');

        for ($i = 0; $i < 40; $i++) {
            User::create([
                'prefix'   => $fakerTH->randomElement(['นาย', 'นาง', 'นางสาว']),
                'name'     => $fakerTH->firstName,
                'surname'  => $fakerTH->lastName,
                'username' => $fakerEN->userName,
                'email'    => $fakerEN->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role'     => 'ผู้ใช้',
            ]);
        }
    }
}
