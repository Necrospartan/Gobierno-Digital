<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roleuser;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            if ($i <= 2) {
                Roleuser::created([
                    'user_id' => $i,
                    'role_id' => 1,
                ]);
            }
            else{
                Roleuser::created([
                    'user_id' => $i,
                    'role_id' => 2
                ]);
            }
        }
    }
}