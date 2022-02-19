<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::insert([
            [
                'name' => Crypt::encrypt('1st level'),
                'employees' => Crypt::encrypt('15 mitareiter'),
                'amount' => Crypt::encrypt(15),
                'time_period' => 'Monthly',
                'currency_symbol' => Crypt::encrypt('€'),
                'currency_name' => Crypt::encrypt('Euro'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => Crypt::encrypt('2nd level'),
                'employees' => Crypt::encrypt('1000 mitareiter'),
                'amount' => Crypt::encrypt(30),
                'time_period' => 'Monthly',
                'currency_symbol' => Crypt::encrypt('€'),
                'currency_name' => Crypt::encrypt('Euro'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => Crypt::encrypt('3rd level'),
                'employees' => Crypt::encrypt('5000 mitareiter'),
                'amount' => Crypt::encrypt(70),
                'time_period' => 'Monthly',
                'currency_symbol' => Crypt::encrypt('€'),
                'currency_name' => Crypt::encrypt('Euro'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
