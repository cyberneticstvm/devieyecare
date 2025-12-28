<?php

namespace Database\Seeders;

use App\Models\Extra;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        $pmodes = [
            'Cash',
            'Card',
            'Cheque',
            'Upi',
            'Bank Transfer',
            'Other',
        ];

        $ptypes = [
            'Advance',
            'Partial',
            'Balance',
            'Other',
        ];

        $devices = [
            'Computer',
            'Android',
            'iOS',
            'Tablet',
            'Other',
        ];

        $regtypes = [
            'New',
            'Review',
            'Camp',
            'Appointment',
        ];

        $ctypes = [
            'Consultation',
            'Certificate',
            'Surgery',
        ];

        $genders = [
            'Male',
            'Female',
            'Other',
        ];

        $heads = [
            'Income',
            'Expense',
        ];

        $thickness = [
            'Normal Thick',
            'Maximum Thin',
            'Thin',
        ];

        $statuses1 = [
            'RGSTD',
            'CNLT',
        ];

        $statuses2 = [
            'BKD',
            'PNDG',
            'UPRS',
            'RFD',
            'DLVD'
        ];

        foreach ($months as $month) {
            Extra::insert(['name' => $month, 'category' => 'month']);
        }

        foreach ($devices as $device) {
            Extra::insert(['name' => $device, 'category' => 'device']);
        }

        foreach ($regtypes as $rtype) {
            Extra::insert(['name' => $rtype, 'category' => 'rtype']);
        }

        foreach ($ctypes as $ctype) {
            Extra::insert(['name' => $ctype, 'category' => 'ctype']);
        }

        foreach ($pmodes as $pmode) {
            Extra::insert(['name' => $pmode, 'category' => 'pmode']);
        }

        foreach ($ptypes as $ptype) {
            Extra::insert(['name' => $ptype, 'category' => 'ptype']);
        }

        foreach ($genders as $gender) {
            Extra::insert(['name' => $gender, 'category' => 'gender']);
        }

        foreach ($heads as $head) {
            Extra::insert(['name' => $head, 'category' => 'head']);
        }

        foreach ($thickness as $thick) {
            Extra::insert(['name' => $thick, 'category' => 'thickness']);
        }

        foreach ($statuses1 as $status) {
            Extra::insert(['name' => $status, 'category' => 'registration']);
        }

        foreach ($statuses2 as $status) {
            Extra::insert(['name' => $status, 'category' => 'order']);
        }

        $user = User::find(1);
        $role = Role::find(1);
        UserDevice::insert([
            'user_id' => $user->id,
            'device_id' => Extra::where('category', 'device')->first()->id,
        ]);
        $user->assignRole($role->id, teamId());
    }
}
