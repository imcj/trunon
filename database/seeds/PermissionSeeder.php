<?php

use Illuminate\Database\Seeder;

use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $p = Permission::create(['slug' => 'read.process2', 'name' => '12', 'model' => 'App\Model\Team']);
        // // $p->model = 'App\Model\Team';
        // // $p->save();
        // exit();
        $developerRole = Role::create([
            'name' => 'Developer',
            'slug' => 'developer'
        ]);

        $userRole = Role::create([
            'name' => 'User',
            'slug' => 'user'
        ]);

        $createPermission = Permission::create([
            'name' => 'Create process',
            'slug' => 'create.process'
        ]);

        $readPermission = Permission::create([
            'name' => 'Read process',
            'slug' => 'read.process'
        ]);

        $developerRole->attachPermission($createPermission);
        $developerRole->attachPermission($readPermission);

        $userRole->attachPermission($readPermission);
    }
}
