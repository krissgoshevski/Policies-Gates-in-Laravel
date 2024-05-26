<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the role IDs
        // $adminRoleId = Role::where('name', 'admin')->value('id');
        // $userRoleId = Role::where('name', 'user')->value('id');
        // $superUserRoleId = Role::where('name', 'super_user')->value('id');

        // Create an admin user
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@example.com';
        $admin->password = bcrypt('password');
        $admin->role_id = 1;
        $admin->save();

        // Create a user
        $user = new User();
        $user->name = 'User';
        $user->email = 'user@example.com';
        $user->password = bcrypt('password');
        $user->role_id = 2;
        $user->save();

        // Create a super_user
        $superUser = new User();
        $superUser->name = 'Super User';
        $superUser->email = 'superuser@example.com';
        $superUser->password = bcrypt('password');
        $superUser->role_id = 3;
        $superUser->save();
    }
}
