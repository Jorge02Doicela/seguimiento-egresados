<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea los roles iniciales
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'graduate']);
        Role::create(['name' => 'employer']);
    }
}
