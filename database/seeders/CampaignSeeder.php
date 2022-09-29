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
        Campaign::factory(10);
        foreach(Campaign::all() as $campaign) {
            $faker = Faker::create();
            $items = Item::inRandomOrder()->take(rand(1,3))->pluck('id');
            $campaign->items()->attach($items, [
                'amount' => $faker->randomNumber(3, false),
            ]);
        };

    }
}
