<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' =>'admin',
            'description'=>'Admin user'
        ]);

        $manager = Role::create([
            'name' =>'manager',
            'description'=>'Manager user'
        ]);

        $user = Role::create([
            'name' =>'user',
            'description'=>'General user'
        ]);
    }
}
