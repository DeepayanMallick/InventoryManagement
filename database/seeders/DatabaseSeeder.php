<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        User::factory(1)->create([
            'role' => 'Admin',
            'email' => 'admin@decorhousebd.com'
        ]);
        User::factory(1)->create([
            'role' => 'Manager',
            'email' => 'manager@decorhousebd.com'
        ]);
    }
}
