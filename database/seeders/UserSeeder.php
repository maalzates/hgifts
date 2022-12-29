<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Manuel Alzate',
            'email' => 'maalzates@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Admin');
        User::factory(20)->create();

        foreach (User::all() as $user) {
            $user->assignRole('Regular');
        }
    }
}
