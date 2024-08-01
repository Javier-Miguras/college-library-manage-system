<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Campus;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campusList = Campus::all();
        $books = Book::all();

        foreach($campusList as $campus){

            foreach($books as $book){

                DB::table('books_stock')->insert([
                    'stock' => fake()->numberBetween(0, 5),
                    'campus_id' => $campus->id,
                    'book_id' => $book->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
    }
}
