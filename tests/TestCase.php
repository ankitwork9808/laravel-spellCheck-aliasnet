<?php

namespace Tests;

use App\Models\Category;
use App\Models\Company;
use App\Models\Status;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Crypt;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';

    /**
     * prepareData
     *
     * @return void
     */
    public function prepareData() : void
    {
        Company::create(
            [
                'name'          => Crypt::encrypt('ABC Begleitung'),
                'token'         => $this->token,
                'wsn'           => Crypt::encrypt('WSN-cn3ui3'),
                'phone'         => Crypt::encrypt('1234567890'),
                'email'         => Crypt::encrypt('abc@gmail.com'),
                'address'       => Crypt::encrypt('Friedrichstrasse 6'),
                'city'          => Crypt::encrypt('Berlin'),
                'postal_code'   => Crypt::encrypt('40221'),
                'note'          => Crypt::encrypt('Dies ist eine Testnotiz!'),
                'companyid'     => '123',
            ]
        );

        Category::create([
            'name' => 'Steuern',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Status::create([
            'name' => 'Eingereicht',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function createCompany($random_number){

        Company::create(
            [
                'companyid'     => $random_number,
                'name'          => Crypt::encrypt('ABC Begleitung'),
                'token'         => $random_number,
                'phone'         => Crypt::encrypt('1234567890'),
                'email'         => Crypt::encrypt('abc@gmail.com'),
                'address'       => Crypt::encrypt('Friedrichstrasse 6'),
                'city'          => Crypt::encrypt('Berlin'),
                'state_id'      => null,
                'country_id'    => null,
                'postal_code'   => Crypt::encrypt('40221'),
                'note'          => Crypt::encrypt('Dies ist eine Testnotiz!')
            ]
        );

        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Category::insert([
            [
                'name' => 'Steuern',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Verwaltung',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rechtliches',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Betriebsbereit',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Verlängerbar',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Humanressourcen',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $company = Company::where('companyid', $random_number)->first();

        $company->name          = Crypt::encrypt($company->name);
        $company->phone         = Crypt::encrypt($company->phone);
        $company->email         = Crypt::encrypt($company->email);
        $company->address       = Crypt::encrypt($company->address);
        $company->city          = Crypt::encrypt($company->city);
        $company->postal_code   = Crypt::encrypt($company->postal_code);
        $company->note          = Crypt::encrypt($company->note);
        return $company;
    }
}
