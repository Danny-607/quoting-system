<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            // Creating permissions
            Permission::create(['name' => 'view admin dashboard']);
            Permission::create(['name' => 'view manager dashboard']);
            Permission::create(['name' => 'view customer dashboard']);

            Permission::create(['name' => 'manage users']);
            Permission::create(['name' => 'manage roles']);
            Permission::create(['name' => 'manage projects']);
            Permission::create(['name' => 'manage services']);
            Permission::create(['name' => 'manage quotes']);
            Permission::create(['name' => 'manage running costs']);
            Permission::create(['name' => 'manage employees']);
            Permission::create(['name' => 'create quotes']);
            
            $adminRole = Role::create(['name' => 'admin']);
            $adminRole->givePermissionTo(Permission::all());
    
            $managerRole = Role::create(['name' => 'manager']);
            $managerRole->givePermissionTo(['view manager dashboard', 'manage projects', 'manage quotes', 'manage services', 'manage running costs', 'manage employees', 'create quotes']);
    
            $customerRole = Role::create(['name' => 'customer']);
            $customerRole->givePermissionTo(['create quotes', 'view customer dashboard']);
        }
    }
}
