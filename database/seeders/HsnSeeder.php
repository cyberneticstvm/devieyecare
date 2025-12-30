<?php

namespace Database\Seeders;

use App\Models\Hsn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HsnSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hsn::create(
            [
                'name' => 'Lens',
                'short_name' => 'LE',
                'code' => '9015000',
                'tax_percentage' => 5,
                'is_expiry' => false,
            ]
        );
        Hsn::create(
            [
                'name' => 'Frame',
                'short_name' => 'FR',
                'code' => '90031100',
                'tax_percentage' => 5,
                'is_expiry' => false,
            ]
        );
        Hsn::create(
            [
                'name' => 'Contact Lens',
                'short_name' => 'CL',
                'code' => '90013000',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ]
        );
        Hsn::create(
            [
                'name' => 'Sunglass',
                'short_name' => 'SG',
                'code' => '90041000',
                'tax_percentage' => 18,
                'is_expiry' => false,
            ]
        );
        Hsn::create(
            [
                'name' => 'Solution',
                'short_name' => 'SO',
                'code' => '33079020',
                'tax_percentage' => 18,
                'is_expiry' => true,
            ]
        );
        Hsn::create(
            [
                'name' => 'Ointment',
                'short_name' => 'OI',
                'code' => '30049099',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ]
        );
        Hsn::create(
            [
                'name' => 'Eye Drop',
                'short_name' => 'ED',
                'code' => '30042039',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ]
        );
        Hsn::create(
            [
                'name' => 'Tablet',
                'short_name' => 'TA',
                'code' => '30049099',
                'tax_percentage' => 5,
                'is_expiry' => true,
            ]
        );
        Hsn::create(
            [
                'name' => 'Accessory',
                'short_name' => 'AC',
                'code' => '90185090',
                'tax_percentage' => 5,
                'is_expiry' => false,
            ]
        );
    }
}
