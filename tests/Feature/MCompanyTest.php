<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class MCompanyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_manager_company()
    {

        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->company_id = 1;
        $user->save();

        Company::create(
            [
                'companyid' => 12338274,
                'name' => Crypt::encrypt('ABC Begleitung'),
                'token' => 'ba7rgfefb33qrgq7ii3fggdgfhfhwavadfhjvjhefe',
                'phone' => Crypt::encrypt('1234567890'),
                'email' => Crypt::encrypt('abc@gmail.com'),
                'address' => Crypt::encrypt('Friedrichstrasse 6'),
                'city' => Crypt::encrypt('Berlin'),
                'state_id' => null,
                'country_id' => null,
                'postal_code' => Crypt::encrypt('40221'),
                'note' => Crypt::encrypt('Dies ist eine Testnotiz!')
            ]
        );

        $response = $this->actingAs($user)->get('/manager/company');

        $response->assertStatus(200);
    }
}
