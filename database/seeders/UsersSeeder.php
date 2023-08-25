<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 15; $i++) {
            User::insert([
                'name' => 'Usuario' . $i,
                'email' => 'usuario' . $i . '@example.com',
                'password' => Hash::make('12345abc')
            ]);
        }
    }
}
