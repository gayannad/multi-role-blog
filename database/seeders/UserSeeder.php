<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();

        $managerRole = Role::where('name', 'manager')->first();

        $userRole = Role::where('name', 'user')->first();

        //admin user create
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $adminUser->roles()->attach($adminRole);

        //manager user create
        $managerUser = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $managerUser->roles()->attach($managerRole);

        //normal user create
        $user = User::create([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->roles()->attach($userRole);

    }
}
