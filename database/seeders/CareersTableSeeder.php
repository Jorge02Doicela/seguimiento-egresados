<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('careers')->updateOrInsert(
            ['id' => 0],
            [
                'name' => 'General',
                'description' => 'Encuestas para todos los egresados, sin importar la carrera',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
