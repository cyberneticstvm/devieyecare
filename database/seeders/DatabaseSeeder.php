<?php

namespace Database\Seeders;

use App\Models\Extra;
use App\Models\Hsn;
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

        $heads = [
            'Income',
            'Expense',
        ];

        $statuses = [
            'RGSTD',
            'CNLT',
            'BKD',
            'PNDG',
            'UPRS',
            'RFD',
            'DLVD',
            'CANCLD'
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

        foreach ($statuses as $status) {
            Extra::insert(['name' => $status, 'category' => 'order']);
        }

        foreach ($heads as $head) {
            Extra::insert(['name' => $head, 'category' => 'head']);
        }

        $hsns = [
            [
                'name' => 'Lens',
                'short_name' => 'LE',
                'code' => '9015000',
                'tax_percentage' => 5,
                'is_expiry' => false,
            ],
            [
                'name' => 'Frme',
                'short_name' => 'FR',
                'code' => '90031100',
                'tax_percentage' => 5,
                'is_expiry' => false,
            ],
            [
                'name' => 'Contact Lens',
                'short_name' => 'CL',
                'code' => '90013000',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ],
            [
                'name' => 'Sunglass',
                'short_name' => 'SG',
                'code' => '90041000',
                'tax_percentage' => 18,
                'is_expiry' => false,
            ],
            [
                'name' => 'Solution',
                'short_name' => 'So',
                'code' => '33079020',
                'tax_percentage' => 18,
                'is_expiry' => true,
            ],
            [
                'name' => 'Ointment',
                'short_name' => 'OI',
                'code' => '30049099',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ],
            [
                'name' => 'Eye Drop',
                'short_name' => 'ED',
                'code' => '30042039',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ],
            [
                'name' => 'Tablet',
                'short_name' => 'TA',
                'code' => '30049099',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ],
            [
                'name' => 'Accessory',
                'short_name' => 'AC',
                'code' => '90185090',
                'tax_percentage' => 5,
                'is_expiry' => false,
            ],
        ];

        Hsn::create($hsns);
    }
}
