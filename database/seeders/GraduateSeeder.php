<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Graduate;
use Illuminate\Support\Facades\Hash;

class GraduateSeeder extends Seeder
{
    public function run()
    {
        $email = 'egresado1@sucre.edu';
        if (!User::where('email', $email)->exists()) {
            $user = User::create([
                'name' => 'Egresado Ejemplo',
                'email' => $email,
                'password' => Hash::make('egresado123'),
            ]);
            $user->assignRole('graduate');

            Graduate::create([
                'user_id' => $user->id,
                'cohort_year' => 2023,  // 👈 agrega esto
                'company' => 'Empresa Ejemplo S.A.',
                'position' => 'Desarrollador',
                'salary' => 1500.00,
                'sector' => 'privado',
                'portfolio_url' => 'https://portfolio.egresado.com',
                'cv_path' => null,
                'country' => 'Ecuador',
                'city' => 'Quito',
            ]);
        }
    }
}
