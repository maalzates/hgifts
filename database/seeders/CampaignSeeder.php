<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Campaign;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;



class CampaignSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campaign::factory(10)->create();

        // Seeding pivot table with custom field 'count', for each campaign record, we will access the relationship and add data
        foreach(Campaign::all() as $campaign) {
            // Instantiate Faker
            $faker = Faker::create();
            // Obtain item id's array randomly 
            $items = Item::inRandomOrder()->take(rand(1,3))->pluck('id');
            // Access to pivot table and passing the custom field as second argument in attach method
            $campaign->items()->attach($items, [
                'count' => $faker->randomNumber(3, false),
            ]);
        };

    }
}
