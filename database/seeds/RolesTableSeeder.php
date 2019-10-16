<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete postsCatalog']);
        Permission::create(['name' => 'create postsCatalog']);
        Permission::create(['name' => 'edit postsCatalog']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'edit rolesAndPermissions']);
        Permission::create(['name' => 'access webPanel']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'create catalogs']);
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'delete events']);
        Permission::create(['name' => 'edit profile']);
        Permission::create(['name' => 'change password']);


        // create roles and assign created permissions

        $role = Role::create(['name' => 'grant admin'])
            ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['create users', 'edit users', 'delete users', 'edit rolesAndPermissions', 'edit profile', 'access webPanel']);

        $role = Role::create(['name' => 'posts editor'])
            ->givePermissionTo(['delete posts', 'create posts', 'edit posts', 'create categories', 'create events', 'edit events', 'delete events', 'edit profile', 'access webPanel']);

        $role = Role::create(['name' => 'catalogs editor'])
            ->givePermissionTo(['delete postsCatalog', 'create postsCatalog', 'edit postsCatalog', 'create catalogs', 'access webPanel']);

        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['edit profile', 'change password']);
    }
}
