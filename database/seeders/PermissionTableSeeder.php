<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $permissions = [
            'invoices',
            'paid invoices',
            'partial paid invoices',
            'unpaid invoices',
            'reports',
            'invoices reports',
            'users reports',
            'users',
            'users permissions',
            'settings',
            'products',
            'sections',

            'add invoice',
            'remove invoice',
            'export invoice as excel',
            'change invoice status',
            'edit invoice',
            'archive invoice',
            'print invoice',
            'add attachment',
            'remove attachment',

            'add user',
            'edit user',
            'remove user',
            
            'show permission',
            'add permission',
            'edit permission',
            'remove permission',
            
            'add product',
            'edit product',
            'remove product',

            'add section',
            'edit section',
            'remove section',

            'notification'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
