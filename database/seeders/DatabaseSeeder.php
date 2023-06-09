<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*HERE*/
        $this->call(RoleSeeder::class);
        
        $this->call(ItemSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(CommentSeeder::class);
        
    }
}
