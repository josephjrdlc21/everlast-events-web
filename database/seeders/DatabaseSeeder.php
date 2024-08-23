<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Seed the roles
         $this->call(RoleSeeder::class);
        
         // Seed the permissions
         $this->call(Permissionseeder::class);
 
         // Assign permissions to roles
         $this->call(AssignPermissionsToRoleSeeder::class);
 
         // Create admin account
         $this->call(AdminAccountSeeder::class);
    }
}
