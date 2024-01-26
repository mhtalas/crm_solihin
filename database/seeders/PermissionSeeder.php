<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions

        Permission::create(['name' => 'list customer']);
        Permission::create(['name' => 'view customer']);
        Permission::create(['name' => 'create customer']);
        Permission::create(['name' => 'update customer']);
        Permission::create(['name' => 'delete customer']);
        Permission::create(['name' => 'restore customer']);
        Permission::create(['name' => 'force delete customer']);

        Permission::create(['name' => 'list document']);
        Permission::create(['name' => 'view document']);
        Permission::create(['name' => 'create document']);
        Permission::create(['name' => 'update document']);
        Permission::create(['name' => 'delete document']);
        Permission::create(['name' => 'restore document']);
        Permission::create(['name' => 'force delete document']);

        Permission::create(['name' => 'list lead source']);
        Permission::create(['name' => 'view lead source']);
        Permission::create(['name' => 'create lead source']);
        Permission::create(['name' => 'update lead source']);
        Permission::create(['name' => 'delete lead source']);
        Permission::create(['name' => 'restore lead source']);
        Permission::create(['name' => 'force delete lead source']);

        Permission::create(['name' => 'list pipeline stage']);
        Permission::create(['name' => 'view pipeline stage']);
        Permission::create(['name' => 'create pipeline stage']);
        Permission::create(['name' => 'update pipeline stage']);
        Permission::create(['name' => 'delete pipeline stage']);
        Permission::create(['name' => 'restore pipeline stage']);
        Permission::create(['name' => 'force delete pipeline stage']);

        Permission::create(['name' => 'list product']);
        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'update product']);
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'restore product']);
        Permission::create(['name' => 'force delete product']);

        Permission::create(['name' => 'list product item']);
        Permission::create(['name' => 'view product item']);
        Permission::create(['name' => 'create product item']);
        Permission::create(['name' => 'update product item']);
        Permission::create(['name' => 'delete product item']);
        Permission::create(['name' => 'restore product item']);
        Permission::create(['name' => 'force delete product item']);

        Permission::create(['name' => 'list product quote']);
        Permission::create(['name' => 'view product quote']);
        Permission::create(['name' => 'create product quote']);
        Permission::create(['name' => 'update product quote']);
        Permission::create(['name' => 'delete product quote']);
        Permission::create(['name' => 'restore product quote']);
        Permission::create(['name' => 'force delete product quote']);

        Permission::create(['name' => 'list project']);
        Permission::create(['name' => 'view project']);
        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'update project']);
        Permission::create(['name' => 'delete project']);
        Permission::create(['name' => 'restore project']);
        Permission::create(['name' => 'force delete project']);

        Permission::create(['name' => 'list project pipeline stage']);
        Permission::create(['name' => 'view project pipeline stage']);
        Permission::create(['name' => 'create project pipeline stage']);
        Permission::create(['name' => 'update project pipeline stage']);
        Permission::create(['name' => 'delete project pipeline stage']);
        Permission::create(['name' => 'restore project pipeline stage']);
        Permission::create(['name' => 'force delete project pipeline stage']);

        Permission::create(['name' => 'list quote']);
        Permission::create(['name' => 'view quote']);
        Permission::create(['name' => 'create quote']);
        Permission::create(['name' => 'update quote']);
        Permission::create(['name' => 'delete quote']);
        Permission::create(['name' => 'restore quote']);
        Permission::create(['name' => 'force delete quote']);

        Permission::create(['name' => 'list tag']);
        Permission::create(['name' => 'view tag']);
        Permission::create(['name' => 'create tag']);
        Permission::create(['name' => 'update tag']);
        Permission::create(['name' => 'delete tag']);
        Permission::create(['name' => 'restore tag']);
        Permission::create(['name' => 'force delete tag']);

        Permission::create(['name' => 'list task']);
        Permission::create(['name' => 'view task']);
        Permission::create(['name' => 'create task']);
        Permission::create(['name' => 'update task']);
        Permission::create(['name' => 'delete task']);
        Permission::create(['name' => 'restore task']);
        Permission::create(['name' => 'force delete task']);


        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'Sales']);
        $userRole->givePermissionTo($currentPermissions);

        Permission::create(['name' => 'list branch']);
        Permission::create(['name' => 'view branch']);
        Permission::create(['name' => 'create branch']);
        Permission::create(['name' => 'update branch']);
        Permission::create(['name' => 'delete branch']);
        Permission::create(['name' => 'restore branch']);
        Permission::create(['name' => 'force delete branch']);

        Permission::create(['name' => 'list city']);
        Permission::create(['name' => 'view city']);
        Permission::create(['name' => 'create city']);
        Permission::create(['name' => 'update city']);
        Permission::create(['name' => 'delete city']);
        Permission::create(['name' => 'restore city']);
        Permission::create(['name' => 'force delete city']);

        Permission::create(['name' => 'list user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'restore user']);
        Permission::create(['name' => 'force delete user']);

        Permission::create(['name' => 'list department']);
        Permission::create(['name' => 'view department']);
        Permission::create(['name' => 'create department']);
        Permission::create(['name' => 'update department']);
        Permission::create(['name' => 'delete department']);
        Permission::create(['name' => 'restore department']);
        Permission::create(['name' => 'force delete department']);

        Permission::create(['name' => 'list province']);
        Permission::create(['name' => 'view province']);
        Permission::create(['name' => 'create province']);
        Permission::create(['name' => 'update province']);
        Permission::create(['name' => 'delete province']);
        Permission::create(['name' => 'restore province']);
        Permission::create(['name' => 'force delete province']);

        $adminPermission = Permission::all();
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($adminPermission);

        $user = User::whereEmail('admin@admin.com')->first();
        $superAdmin = Role::create(['name' => 'Super Admin']);
        if ($user) {
            $user->assignRole($superAdmin);
        }
    }
}
