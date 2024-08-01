<?php

namespace Database\Seeders;

use App\Models\AcademicProgram;
use App\Models\Campus;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campusList = Campus::all();
        $academicPrograms = AcademicProgram::all()->pluck('id')->toArray();

        $now = Carbon::now();


        foreach($campusList as $campus){

            $assignedPrograms = [];

            while(count($assignedPrograms) < fake()->numberBetween(30, 44)){

                $programId = fake()->randomElement($academicPrograms);

                if(!in_array($programId, $assignedPrograms)){
                    DB::table('campus_programs')->insert([
                        'campus_id' => $campus->id,
                        'program_id' => $programId,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);

                    $assignedPrograms[] = $programId;
                }

            }
        }
    }
}
