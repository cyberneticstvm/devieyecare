<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'branch-list',
            'branch-create',
            'branch-edit',
            'branch-delete',
            'doctor-list',
            'doctor-create',
            'doctor-edit',
            'doctor-delete',
            'appointment-list',
            'appointment-create',
            'appointment-edit',
            'appointment-delete',
            'camp-list',
            'camp-create',
            'camp-edit',
            'camp-delete',
            'camp-patient-list',
            'camp-patient-create',
            'camp-patient-edit',
            'camp-patient-delete',
            'vehicle-list',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'vehicle-payment-list',
            'vehicle-payment-create',
            'vehicle-payment-edit',
            'vehicle-payment-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
