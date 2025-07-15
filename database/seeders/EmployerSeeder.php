<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployerSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Empleador Ejemplo',
            'email' => 'empleador@gmail.com',
            'password' => Hash::make('Empleador123.'),
        ]);

        $user->assignRole('employer');

        Employer::create([
            'user_id' => $user->id,
            'company_name' => 'Empresa Contratante S.A.',
            'phone' => '0999999999',
            'address' => 'Av. Principal 123',
            'website' => 'https://www.empresacontratante.com',
            'sector' => 'Tecnología',
            'city' => 'Quito',
            'is_verified' => false,
        ]);
    }
}
