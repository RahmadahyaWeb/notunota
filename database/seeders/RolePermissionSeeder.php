<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // invoices
            'view invoices',
            'create invoices',
            'update invoices',
            'delete invoices',
            'send invoices',

            // customers
            'view customers',
            'create customers',
            'update customers',
            'delete customers',

            // products
            'view products',
            'create products',
            'update products',
            'delete products',

            // users
            'manage users',

            // reports
            'view reports',
            'export reports',

            // business
            'update business',
            'delete business',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        $owner = Role::firstOrCreate(['name' => 'owner']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $staff = Role::firstOrCreate(['name' => 'staff']);

        // OWNER
        $owner->syncPermissions(Permission::all());

        // ADMIN
        $admin->syncPermissions([
            'view invoices',
            'create invoices',
            'update invoices',
            'delete invoices',
            'send invoices',

            'view customers',
            'create customers',
            'update customers',
            'delete customers',

            'view products',
            'create products',
            'update products',
            'delete products',

            'view reports',
            'export reports',
        ]);

        // STAFF
        $staff->syncPermissions([
            'view invoices',
            'create invoices',
            'update invoices',
            'send invoices',

            'view customers',
            'create customers',
            'update customers',

            'view products',
        ]);
    }
}
