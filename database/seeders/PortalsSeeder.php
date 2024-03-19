<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Portal;

class PortalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Portal::create([
            'name' => 'Property Finder',
        ]);

        Portal::create([
            'name' => 'Bayut',
        ]);

        Portal::create([
            'name' => 'Dubizzle',
        ]);
    }
}
