<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'graduate']);
        Role::firstOrCreate(['name' => 'employer']);

        $adminEmail = 'admin.sucre@gmail.com';
        if (!User::where('email', $adminEmail)->exists()) {
            $admin = User::create([
                'name' => 'Admin Sucre',
                'email' => $adminEmail,
                'password' => Hash::make('Admin1234.'),
            ]);
            $admin->assignRole('admin');
        }
    }
}
