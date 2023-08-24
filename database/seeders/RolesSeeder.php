<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'administrador',
            'slug' => '',
            'description' => date('Y-m-d H:i:s')
        ]);
        Role::create([
            'name' => 'usuario',
            'slug' => '',
            'description' => date('Y-m-d H:i:s')
        ]);
    }
}
