<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario 1
    User::factory()->create([
        'name' => 'Armando Perez',
        'email' => 'asd@gmail.com',
        'password' => bcrypt('asd'),
        'dni' => '12345678A',
        'phone' => '123-456-7890',
        'address' => '123 Main St, City, Afganistan',
    ])->assignRole('Doctor');

    // Usuario 2
    User::factory()->create([
        'name' => 'qwe',
        'email' => 'qwe@gmail.com',
        'password' => bcrypt('asd'),
        'dni' => '87654321B',
        'phone' => '098-765-4321',
        'address' => '456 Another St, City, Bolivia',
    ])->assignRole('Paciente');

    // Usuario 3 (opcional, otro ejemplo)
    User::factory()->create([
        'name' => 'zxc',
        'email' => 'zxc@gmail.com',
        'password' => bcrypt('asd'),
        'dni' => '11223344C',
        'phone' => '555-555-5555',
        'address' => '789 Different St, City, Colombia',
    ])->assignRole('Administrador');
    }
}
