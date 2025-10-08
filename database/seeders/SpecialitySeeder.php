<?php

namespace Database\Seeders;

use App\Models\Speciality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialities = [
            "Dermatología",
            "Cardiología",
            'Endocrinología',
            'Ginecología',
            'Hematología',
        ];

        foreach ($especialities as $speciality){
            Speciality::create([
                'name' => $speciality
            ]);
        }
    }
}
