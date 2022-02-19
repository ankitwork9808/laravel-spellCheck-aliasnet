<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ComapnySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(
            [
                'companyid' => 123,
                'name' => Crypt::encrypt('ABC Begleitung'),
                'token' => 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz',
                'phone' => Crypt::encrypt('1234567890'),
                'email' => Crypt::encrypt('abc@gmail.com'),
                'address' => Crypt::encrypt('Friedrichstrasse 6'),
                'city' => Crypt::encrypt('Berlin'),
                'state_id' => 1256,
                'country_id' => 81,
                'postal_code' => Crypt::encrypt('40221'),
                'note' => Crypt::encrypt('Dies ist eine Testnotiz!')
            ]
        );
    }
}
