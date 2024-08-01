<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $santiagoId = 1;
        $vinaId = 2;
        $valdiviaId = 3;

        $now = Carbon::now();

        DB::table('towns')->insert([
            'name' => 'Santiago centro',
            'city_id' => $santiagoId,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('towns')->insert([
            'name' => 'Ñuñoa',
            'city_id' => $santiagoId,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('towns')->insert([
            'name' => 'San Miguel',
            'city_id' => $santiagoId,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('towns')->insert([
            'name' => 'Valdivia',
            'city_id' => $valdiviaId,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('towns')->insert([
            'name' => 'Viña del mar',
            'city_id' => $vinaId,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
