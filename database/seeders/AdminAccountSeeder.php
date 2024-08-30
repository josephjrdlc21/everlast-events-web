<?php

namespace Database\Seeders;

use App\Laravel\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cred = User::where('name', 'Super Admin')->where('email', 'admin@gmail.coml')->first();

        if(!$cred){
            $user = new User;
            $user->firstname = "Super";
            $user->lastname = "Admin";
            $user->name = "Super Admin";
            $user->email = "admin@gmail.com";
            $user->username = "master_admin";
            $user->password = bcrypt("admin");
            $user->status = "active";
            $user->user_type = "portal";
            $user->save();
    
            $role = Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'portal']);
            $user->assignRole($role);
        }
    }
}
