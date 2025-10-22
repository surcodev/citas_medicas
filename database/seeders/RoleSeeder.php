<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Doctor',
        ])->givePermissionTo(Permission::all());
        
        $roles = [
            'Administrador' => [
                'access_dasboard',

                'create_appointment',
                'read_appointment',
                'update_appointment',
                'delete_appointment',

                'read_calendar',
            ],
            'Paciente' => [
                'access_dasboard',
                'create_appointment',
                'read_appointment',
                'read_calendar',
            ],
            'Recepcionista' => [
                'access_dasboard',

                'create_user',
                'read_user',
                'update_user',
                'delete_user',

                'read_patient',
                'update_patient',

                'read_doctor',
                'update_doctor',

                'create_appointment',
                'read_appointment',
                'update_appointment',
                'delete_appointment',

                'read_calendar',
            ],
        ];

        foreach ($roles as $role => $permissions) {
            Role::create([
                'name' => $role,
            ])
            ->givePermissionTo($permissions);
        }
    }
}
