<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar al seeder de roles
        $this->call(RoleSeeder::class);

        // Crear usuario de prueba
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('secret123'), // Asegúrate de ponerle una contraseña
        ]);

        // Asignar rol admin al usuario de prueba
        $user->assignRole('admin');
    }
}
