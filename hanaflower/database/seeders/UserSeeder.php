<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //buat login admin nya
        User::create([
            'name' => 'Admin Hana Flower Story',
            'email' => 'hana@gmail.com',
            'password' => bcrypt('hana21') //buat hash password yang mau disimpen ke db, pass nya hana21
        ]);
    }
}

