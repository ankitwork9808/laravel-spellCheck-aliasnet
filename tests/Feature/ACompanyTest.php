<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;
use Illuminate\Support\Str;

class ACompanyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * test_companies_index_with_admin
     *
     * @return void
     */
    public function test_companies_index_with_admin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/companies');

        $response->assertStatus(200);
    }

    /**
     * test_companies_index_with_detector
     *
     * @return void
     */
    public function test_companies_index_with_detector()
    {
        $user = User::factory()->create();
        $user->type = 'Detector';
        $user->save();

        $response = $this->actingAs($user)->get('/admin/companies');

        $response->assertStatus(200);
    }

    /**
     * test_companies_index_with_manager
     *
     * @return void
     */
    public function test_companies_index_with_manager()
    {
        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->save();

        $response = $this->actingAs($user)->get('/admin/companies');

        $response->assertStatus(302);
    }

    /**
     * test_create_company
     *
     * @return void
     */
    public function test_create_company()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/companies/create');

        $response->assertStatus(200);
    }

    /**
     * test_edit_company
     *
     * @return void
     */
    public function test_edit_company()
    {
        $user = User::factory()->create();

        Company::create(
            [
                'companyid' => 12338274,
                'name' => Crypt::encrypt('ABC Begleitung'),
                'token' => 'ba7rgfefb33qrgq7ii3fghfhwavadfhjvjhefe',
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

        $response = $this->actingAs($user)->get('/admin/companies/12338274/edit');

        $response->assertStatus(200);
    }

    /**
     * test_store_company
     *
     * @return void
     */
    public function test_store_company()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
                        ->post('admin/companies', [
                            'name' => 'ABCD Begleitung',
                            'phone' => '1234567890',
                            'email' => 'abcde@gmail.com',
                            'address' => 'Friedrichstrasse6',
                            'city' => 'Berlin',
                            'state_id' => null,
                            'country_id' => null,
                            'postal_code' => '40221',
                            'website' => null,
                            'note' => 'Dies ist eine Testnotiz!'
                        ]);
        $company = Company::first();
        $this->assertEquals(Crypt::decrypt($company->email), 'abcde@gmail.com');
    }

    /**
     * test_store_company_wrong_data
     *
     * @return void
     */
    public function test_store_company_wrong_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('admin/companies', [
                            'name' => null,
                            'phone' => '1234567890',
                            'email' => 'abcde@gmail.com',
                            'address' => 'Friedrichstrasse6',
                            'city' => 'Berlin',
                            'state_id' => null,
                            'country_id' => null,
                            'postal_code' => '40221',
                            'note' => 'Dies ist eine Testnotiz!'
                        ]);

        $response->assertStatus(302);
    }

    /**
     * test_update_company
     *
     * @return void
     */
    public function test_update_company()
    {
        $user = User::factory()->create();

        Company::create(
            [
                'companyid' => 12338274,
                'name' => Crypt::encrypt('ABC Begleitung'),
                'token' => 'ba7rgfefb33qrgq7ii3fghfhwavadfhjvjhefe',
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

        $this->actingAs($user)
                        ->put('admin/companies/12338274', [
                            'name' => 'ABC Begleitung',
                            'phone' => '1234567890',
                            'email' => 'abcdef@gmail.com',
                            'address' => 'Friedrichstrasse 6',
                            'city' => 'Berlin',
                            'state_id' => null,
                            'country_id' => null,
                            'postal_code' => '40221',
                            'note' => 'Dies ist eine Testnotiz!',
                            'website' => null,
                        ]);

        $new_user = Company::first();
        $this->assertEquals(Crypt::decrypt($new_user->email), 'abcdef@gmail.com');
    }

    /**
     * test_destroy_company
     *
     * @return void
     */
    public function test_destroy_company()
    {
        $user = User::factory()->create();

        Company::create(
            [
                'companyid' => 45345255225,
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

        $response = $this->actingAs($user)->delete('admin/companies/45345255225');
        $response->assertStatus(200);
    }

    /**
     * test_destroy_company_with_dependent_data
     *
     * @return void
     */
    public function test_destroy_company_with_dependent_data()
    {
        $user = User::factory()->create();

        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => Crypt::encrypt('ABC Begleitung'),
                'token' => $token,
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

        $wsn = strtoupper(Str::random(8));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => 12338274,
            'subject' => 'This is test subject',
            'category_id' => null,
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '2bidina96aogsvv5lsmr123~sample1.pdf,twcvea9sfchezkcuqnjp123~sample2.pdf',
        ]);

        $company = Company::with(['cases'])->where('id', $company->id)->first();

        $response = $this->actingAs($user)->delete('admin/companies/'.$company->companyid);
        $response->assertStatus(200);
    }


    /**
     * test_search_company
     *
     * @return void
     */
    public function test_search_company()
    {
        $user = User::factory()->create();

        Company::create(
            [
                'companyid' => 45345255225,
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

        $response = $this->actingAs($user)
                        ->post('admin/companies-search', [
                            'keyword' => 'ABC Begleitung',
                        ]);

        $response->assertStatus(200);
    }

    /**
     * test_search_company_with_empty_data
     *
     * @return void
     */
    public function test_search_company_with_empty_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('admin/companies-search', [
                            'keyword' => 'ABC Begleitung',
                        ]);

        $response->assertStatus(200);
    }

    /**
     * test_show_company
     *
     * @return void
     */
    public function test_show_company()
    {
        $user = User::factory()->create();

        Company::create(
            [
                'companyid' => 45345255225,
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

        $response = $this->actingAs($user)->get('admin/companies/45345255225');

        $response->assertStatus(200);
    }

    /**
     * test_show_company_with_wrong_company
     *
     * @return void
     */
    public function test_show_company_with_wrong_company()
    {
        $user = User::factory()->create();

        Company::create(
            [
                'companyid' => 45345255225,
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

        $response = $this->actingAs($user)->get('admin/companies/45345255225');

        $response->assertStatus(200);
    }

    public function test_update_company_status()
    {
        $user = User::factory()->create();

        $company = Company::create(
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

        $response = $this->actingAs($user)
                        ->post('admin/company-status', [
                            'id' => 1,
                            'status' => 1,
                        ]);

        $response->assertStatus(200);
    }
}