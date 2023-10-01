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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Admin');
        User::create([
            'name' => 'Regular',
            'email' => 'regular@regular.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Regular');

        User::factory(20)->create();

        foreach (User::all() as $user) {
            $user->assignRole('Regular');
        }
    }
}
