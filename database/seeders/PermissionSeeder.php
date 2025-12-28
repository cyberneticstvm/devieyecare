<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\User;
use App\Models\UserBranch;
use App\Models\UserDevice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            'bulk-order-update',
            'purchase-list',
            'purchase-create',
            'purchase-edit',
            'purchase-delete',
            'transfer-list',
            'transfer-create',
            'transfer-edit',
            'transfer-delete',
            'inventory-status',
            'surgery-register',
            'procedure',
            'procedure-create',
            'report-sales',
            'report-pharmacy',
            'report-registration',
            'report-daybook',
            'report-expense',
            'report-login-log',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        foreach (requiredRoles() as $key => $rol):
            Role::create(['guard_name' => 'web', 'name' => $rol, 'team_id' => teamId()]);
        endforeach;

        $user = User::factory()->create([
            'name' => 'Vijoy Sasidharan',
            'email' => 'mail@cybernetics.me',
            'mobile' => '9188848860',
            'password' => Hash::make('stupid'),
        ]);

        $branch = Branch::create([
            'name' => 'Main Store',
            'code' => 'STR',
            'address' => 'Trivandrum',
            'email' => 'store@store.com',
            'contact' => '0123456789',
            'is_store' => 1,
            'display_capacity' => 0,
            'invoice_starts_with' => 1,
            'daily_expense_limit' => 1,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        UserBranch::insert([
            'user_id' => $user->id,
            'branch_id' => $branch->id
        ]);
        /*UserDevice::insert([
            'user_id' => $user->id,
            'device_id' => 1, //Extra::where('category', 'device')->first()->id,
        ]);*/

        $role = Role::find(1);
        $permissions = Permission::pluck('id', 'id')->all();
        $user->assignRole($role->id, teamId());
        $role->syncPermissions($permissions);
    }
}
