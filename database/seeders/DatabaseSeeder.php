<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call([
        //     CountrySeeder::class
        // ]);

        // Author::factory(1000)->create();

        // $this->call([
        //     CategorySeeder::class
        // ]);

        // Book::factory(10000)->create();
        // $this->call([
        //     CitySeeder::class
        // ]);

        // $this->call([
        //     TownSeeder::class
        // ]);

        // $this->call([
        //     CampusSeeder::class
        // ]);

        // $this->call([
        //     CampusProgramSeeder::class
        // ]);

        // $this->call([
        //     BookStockSeeder::class
        // ]);

        // User::factory(20)->create();

        // $this->call([
        //     StudentProgramSeeder::class
        // ]);

        $this->call([
            ReservationSeeder::class
        ]);
    }
}
