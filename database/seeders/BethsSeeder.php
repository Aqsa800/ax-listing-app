<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BethsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bedTypes = ['1', '2', '3', '4', '5', '6', '7'];

        // Iterate over the bed types and insert them into the baths table
        foreach ($bedTypes as $type) {
            DB::table('baths')->insert([
                'name' => $type,
            ]);
        }
    }
}
