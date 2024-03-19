<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the bed types
        $bedTypes = ['Studio', '1', '2', '3', '4', '5', '6', '7'];

        // Iterate over the bed types and insert them into the beds table
        foreach ($bedTypes as $type) {
            DB::table('beds')->insert([
                'name' => $type,
            ]);
        }
    }
}
