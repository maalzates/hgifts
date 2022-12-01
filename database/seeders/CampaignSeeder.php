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
        Campaign::factory(40)->create();

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

            $campaign->users()->attach([
                rand(1,2),
                rand(3,4),
                rand(5,6),
                rand(7,8),
                rand(9,10),
                rand(11,12),
                rand(13,14),
                rand(15,16),
                rand(17,18),
                rand(19,20),
            ]);


        };

    }
}
