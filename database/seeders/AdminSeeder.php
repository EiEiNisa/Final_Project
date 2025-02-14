<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Register;

class AdminSeeder extends Seeder
{

    public function run()
    {
        register::create([
            'name' => 'ณิศวรา',
            'surname' => 'บางทราย',
            'username' => 'ณิศวรา ECP4N',
            'email' => 'nisawarabangsai300146@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        register::create([
            'name' => 'ณิศวรา',
            'surname' => 'บางทราย',
            'username' => 'ณิศวรา ECP4N',
            'email' => 'nisawara.ba@rmuti.ac.th',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
    }
    
}
