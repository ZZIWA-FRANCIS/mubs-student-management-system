<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder {
    public function run(): void {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage students',
            'manage courses',
            'manage registrations',
            'view assigned courses',
            'view available courses',
            'register courses',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles & Assign Permissions
        $admin = Role::firstOrCreate(['name' => 'Administrator']);
        $admin->givePermissionTo(Permission::all());

        $lecturer = Role::firstOrCreate(['name' => 'Lecturer']);
        $lecturer->givePermissionTo(['view assigned courses']);

        $student = Role::firstOrCreate(['name' => 'Student']);
        $student->givePermissionTo(['view available courses', 'register courses']);
    }
}