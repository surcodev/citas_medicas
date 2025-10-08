<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 👨‍⚕️ DOCTOR
        $doctor = User::factory()->create([
            'name' => 'Dr. Luis Gamarra Ramos',
            'email' => 'lgamarra@clinicaperu.com',
            'password' => bcrypt('123456'),
            'dni' => '45896321',
            'phone' => '987654321',
            'address' => 'Av. La Marina 2450, San Miguel, Lima',
        ]);
        $doctor->assignRole('Doctor');
        $doctor->doctor()->create([]); // crea su registro en doctors

        // 👩‍🦰 PACIENTE
        $patient = User::factory()->create([
            'name' => 'María Fernanda Salazar',
            'email' => 'msalazar@gmail.com',
            'password' => bcrypt('123456'),
            'dni' => '72654893',
            'phone' => '912345678',
            'address' => 'Jr. Huancavelica 540, Cercado de Lima',
        ]);
        $patient->assignRole('Paciente');
        $patient->patient()->create([]); // crea su registro en patients

        // 👨‍💼 ADMINISTRADOR
        $admin = User::factory()->create([
            'name' => 'Carlos Pérez Huamán',
            'email' => 'asd@gmail.com',
            'password' => bcrypt('asd'),
            'dni' => '70984512',
            'phone' => '999888777',
            'address' => 'Av. Universitaria 1050, Los Olivos, Lima',
        ]);
        $admin->assignRole('Administrador');
    }
}
