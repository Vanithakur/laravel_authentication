<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
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

        // role
        Role::create(['name' => 'Admin', 'description' => 'admin_role']);
        Role::create(['name' => 'User', 'description' => 'tutor_role']);


        // permission
        Permission::create(['name' => 'manage tasks']);
        Permission::create(['name' => 'create tasks']);
    }
}
