<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'super_admin@admin.com',
            'password' => bcrypt('super_admin@admin.com'),
            'status' => 'مفعل',
            'roles' => ['owner']
        ]);
        $role = Role::create(['name' => 'owner']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $user->syncPermissions($permissions);
    }
}
