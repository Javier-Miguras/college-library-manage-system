<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role', 0)->get();

        $startDate = Carbon::create(2015, 10, 1);
        $endDate = Carbon::create(2023, 10, 1);
        $randomTimestamp = mt_rand($startDate->timestamp, $endDate->timestamp);

        foreach($students as $student){

            $campusIds = Campus::all()->pluck('id');   
            $campusId = fake()->randomElement($campusIds);

            $programIds = Campus::find($campusId)->programs->pluck('id');
            $programId = fake()->randomElement($programIds);

            DB::table('students_programs')->insert([
                'matriculation_date' => Carbon::createFromTimestamp($randomTimestamp),
                'student_id' => $student->id,
                'program_id' => $programId,
                'campus_id' => $campusId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
