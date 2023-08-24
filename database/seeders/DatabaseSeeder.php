<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Roleuser;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            RolesSeeder::class,
            RoleUserSeeder::class
        ]);
    }
}
