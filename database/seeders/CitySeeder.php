<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $now = Carbon::now();

        DB::table('cities')->insert([
            'name' => 'Santiago',
            'country_id' => 35,
            'created_at' => $now,
            'updated_at' => $now

        ]);

        DB::table('cities')->insert([
            'name' => 'Viña del mar',
            'country_id' => 35,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('cities')->insert([
            'name' => 'Valdivia',
            'country_id' => 35,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
