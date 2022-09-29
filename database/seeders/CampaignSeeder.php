<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Campaign;
use Faker\Factory;
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


    }
}
