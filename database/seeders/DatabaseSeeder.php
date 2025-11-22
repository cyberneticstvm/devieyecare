<?php

namespace Database\Seeders;

use App\Models\Extra;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        foreach ($genders as $gender) {
            Extra::insert(['name' => $gender, 'category' => 'gender']);
        }

        foreach ($heads as $head) {
            Extra::insert(['name' => $head, 'category' => 'head']);
        }
    }
}
