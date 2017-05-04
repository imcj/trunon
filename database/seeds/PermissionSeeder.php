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
        $ownerRole = Role::create([
            'name' => 'Owner',
            'slug' => 'owner'
        ]);

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

        $updatePermission = Permission::create([
            'name' => 'Update process',
            'slug' => 'update.process'
        ]);

        $deletePermission = Permission::create([
            'name' => 'Delete process',
            'slug' => 'delete.process'
        ]);

        $developerRole->attachPermission($createPermission);
        $developerRole->attachPermission($readPermission);
        $developerRole->attachPermission($updatePermission);
        $developerRole->attachPermission($deletePermission);

        $userRole->attachPermission($readPermission);

        $ownerRole->attachPermission($createPermission);
        $ownerRole->attachPermission($readPermission);
        $ownerRole->attachPermission($updatePermission);
        $ownerRole->attachPermission($deletePermission);
    }
}
