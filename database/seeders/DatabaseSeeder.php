<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ListingPortal;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BedsSeeder::class,
            BethsSeeder::class,
            PortalsSeeder::class,
        ]);

        \App\Models\Listing::factory()->count(50)->create();

        // Get the IDs of fixed portals
        $portalIds = \App\Models\Portal::pluck('id')->toArray();

        // Create listing portals for each listing with fixed portals
        $listings = \App\Models\Listing::all();

        foreach ($listings as $listing) {
            foreach ($portalIds as $portalId) {
                ListingPortal::create([
                    'listing_id' => $listing->id,
                    'portal_id' => $portalId,
                ]);
            }
        }
    }
}
