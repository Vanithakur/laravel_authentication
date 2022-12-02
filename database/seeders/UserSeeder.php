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
        $adminRole = Role::create(['name' => 'Admin', 'description' => 'admin_role']);
        $adminTutor = Role::create(['name' => 'Tutor', 'description' => 'tutor_role']);
        $adminStudent = Role::create(['name' => 'Student', 'description' => 'student_role']);

        // permission
        $permissionAdmin = Permission::create(['name' => 'manage tasks']);
        $permissionUser = Permission::create(['name' => 'create tasks']);

    }
}
