<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_m_dashboard_with_admin_user
     *
     * @return void
     */
    public function test_m_dashboard_with_admin_user() : void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/manager/dashboard');

        $response->assertStatus(302);
    }

    /**
     * test_m_dashboard_with_manager_user
     *
     * @return void
     */
    public function test_m_dashboard_with_manager_user() : void
    {
        $user = User::factory()->create();

        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => 'ABC Begleitung',
                'token' => $token,
                'phone' => '1234567890',
                'email' => 'abc@gmail.com',
                'address' => 'Friedrichstrasse 6',
                'city' => 'Berlin',
                'state_id' => null,
                'country_id' => null,
                'postal_code' => '40221',
                'note' => 'Dies ist eine Testnotiz!'
            ]
        );

        Category::create([
            'name' => 'Steuern',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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

        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => 1,
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '',
        ]);

        $user->type = 'Manager';
        $user->company_id = 1;
        $user->save();

        $response = $this->actingAs($user)->get('/manager/dashboard');

        $response->assertStatus(200);
    }

    /**
     * test_m_dashboard_with_user
     *
     * @return void
     */
    public function test_m_dashboard_with_user() : void
    {
        $user = User::factory()->create();
        $user->type = 'User';
        $user->save();

        $response = $this->actingAs($user)->get('/manager/dashboard');

        $response->assertStatus(302);
    }
}
