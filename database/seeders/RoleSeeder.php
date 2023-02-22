<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Regular']);

        //* Items * */
        // Watch items list
        Permission::create([
            'name' => 'items.index',
            'description' => 'Watch items list'
        ])->syncRoles([$role1]);
        // Create item
        Permission::create([
            'name' => 'items.create',
            'description' => 'Create items'
        ])->syncRoles([$role1]);
        // Edit Item
        Permission::create([
            'name' => 'items.edit',
            'description' => 'Edit Items'
        ])->syncRoles([$role1]);
        // Delete Item
        Permission::create([
            'name' => 'items.destroy',
            'description' => 'Delete Items'
            ])->syncRoles([$role1]);

        //* Campaigns * */
        // Watch Campaigns list
        Permission::create([
            'name' => 'campaigns.index',
            'description' => 'Watch Campaigns list'
            ])->syncRoles([$role1, $role2]);
        // Create Campaign
        Permission::create([
            'name' => 'campaigns.create',
            'description' => 'Create campaign'
        ])->syncRoles([$role1]);
        // Edit Campaign
        Permission::create([
            'name' => 'campaigns.edit',
            'description' => 'Edit Campaign'
        ])->syncRoles([$role1]);
        // Delete Campaign
        Permission::create([
            'name' => 'campaigns.destroy',
            'description' => 'Delete Campaign'
        ])->syncRoles([$role1]);

        //* USERS * */
        // Watch users list
        Permission::create([
            'name' => 'users.index',
            'description' => 'Watch Users list'
            ])->syncRoles([$role1]);
        // Edit Users
        Permission::create([
            'name' => 'users.edit',
            'description' => 'Edit Campaign'
        ])->syncRoles([$role1]);
    }
}
