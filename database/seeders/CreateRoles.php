<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'super-admin']);
        $role = Role::create(['name' => 'admin']);

        $permissions = ['admins-add', 'admins-edit', 'admins-delete', 'admins-view'];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
