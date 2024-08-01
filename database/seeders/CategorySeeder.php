<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Science Fiction', 'Mathematics', 'Children', 'Medicine', 'Horror',
            'Fantasy', 'Romance', 'Mystery', 'Thriller', 'Biography',
            'Autobiography', 'History', 'Poetry', 'Drama', 'Adventure',
            'Self-Help', 'Health', 'Cooking', 'Travel', 'Art',
            'Photography', 'Graphic Novels', 'Science', 'Technology', 'Philosophy',
            'Religion', 'Spirituality', 'Business', 'Economics', 'Law',
            'Politics', 'Sports', 'Humor', 'Education', 'Music',
            'Crafts & Hobbies', 'Gardening', 'Pets', 'Home & Garden', 'True Crime'
        ];

        $now = Carbon::now();

        foreach($categories as $category){
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
