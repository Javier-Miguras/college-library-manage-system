<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentsIds = User::where('role', 0)->pluck('id'); 

        for($i = 0; $i < 10; $i++){

            $studentId = fake()->randomElement($studentsIds);

            $student = User::find($studentId);

            $booksIds = $student->campus->booksStock()->where('stock', '>', 0)->pluck('book_id');


            $startDate = Carbon::create(2024, 1, 1);
            $now = Carbon::now();

            $randomTimestamp = mt_rand($startDate->timestamp, $now->timestamp);
            $reservationDate = Carbon::createFromTimestamp($randomTimestamp);

            $expirationDate = $reservationDate->copy()->addWeeks(2);


            DB::table('reservations')->insert([
                'expiration_date' => $expirationDate,
                'user_id' => $student->id,
                'book_id' => fake()->randomElement($booksIds),
                'campus_id' => $student->campus->id,
                'created_at' => $reservationDate,
                'updated_at' => $now,
            ]);

        }
    }
}
