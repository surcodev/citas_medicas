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
            'name' => 'Brunella Clarisa Raymundo Villalva',
            'email' => 'brunella_ra@hotmail.com',
            'password' => bcrypt('asd'),
            'dni' => '42257345',
            'phone' => '949888204',
            'address' => 'Montero Rosas 1476 Departamento 502',
        ]);
        $doctor->assignRole('Doctor');
        $doctor->doctor()->create([
            'speciality_id' => 2, // Cardiología
            'biography' => '[COMPLETAR INFORMACION]',
            'medical_license_number' => 'CMP: 053176, RNE: 027483',
        ]);

        // 👩‍🦰 PACIENTE
        $patient = User::factory()->create([
            'name' => 'María Fernanda Salazar',
            'email' => 'msalazar@gmail.com',
            'password' => bcrypt('asd'),
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
