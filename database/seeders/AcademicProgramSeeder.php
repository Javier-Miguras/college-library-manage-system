<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            'Medicine',
            'Nursing',
            'Pharmacy',
            'Dentistry',
            'Biomedical Science',
            'Psychology',
            'Public Health',
            'Physical Therapy',
            'Occupational Therapy',
            'Veterinary Medicine',
            'Health Administration',
            'Radiologic Technology',
            'Medical Laboratory Science',
            'Nutrition and Dietetics',
            'Health Informatics',
            'Sociology',
            'Biology',
            'Chemistry',
            'Physics',
            'Mathematics',
            'Computer Science',
            'Engineering',
            'Architecture',
            'Business Administration',
            'Economics',
            'Finance',
            'Marketing',
            'Accounting',
            'International Relations',
            'Law',
            'Political Science',
            'Environmental Science',
            'Education',
            'History',
            'Philosophy',
            'Literature',
            'Fine Arts',
            'Music',
            'Theater',
            'Culinary Arts',
            'Graphic Design',
            'Industrial Design',
            'Sports Management',
            'Criminal Justice'
        ];

        $now = Carbon::now();

        foreach ($programs as $program) {
            DB::table('academic_programs')->insert([
                'name' => $program,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
