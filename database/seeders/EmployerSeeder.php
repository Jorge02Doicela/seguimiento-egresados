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
            'email' => 'empleador@empresa.com',
            'password' => Hash::make('empleador123'),
        ]);

        $user->assignRole('employer');

        Employer::create([
            'user_id' => $user->id,
            'company_name' => 'Empresa Contratante S.A.',
            'contact_name' => 'Juan Pérez',
            'ruc' => '1234567890001',  // <-- Campo RUC agregado con valor de ejemplo
        ]);
    }
}
