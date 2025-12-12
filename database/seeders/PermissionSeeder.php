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
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'head-list',
            'head-create',
            'head-edit',
            'head-delete',
            'ie-list',
            'ie-create',
            'ie-edit',
            'ie-delete',
            'ms-list',
            'ms-create',
            'ms-edit',
            'ms-delete',
            'store-order-list',
            'store-order-create',
            'store-order-edit',
            'store-order-delete',
            'pharmacy-order-list',
            'pharmacy-order-create',
            'pharmacy-order-edit',
            'pharmacy-order-delete',
            'payment-list',
            'payment-create',
            'payment-edit',
            'payment-delete',
            'order-status-update',
            'purchase-list',
            'purchase-create',
            'purchase-edit',
            'purchase-delete',
            'transfer-list',
            'transfer-create',
            'transfer-edit',
            'transfer-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
