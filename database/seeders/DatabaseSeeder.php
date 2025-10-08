<?php

namespace Database\Seeders;

use App\Models\Speciality;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Ejecuta los seeders de roles primero
    $this->call([
        BloodTypeSeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
        SpecialitySeeder::class,
    ]);
}

}
