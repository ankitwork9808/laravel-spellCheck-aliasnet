<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class ALeadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_lead_index()
    {
        $user = User::factory()->create();
        $this->prepareData();

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
            ]
        ]);

        $response = $this->post('/api/V1/new-lead', [
            'package_id' => 1,
            'name' => 'Sam',
            'email' => 'test@gmail.com',
            'phone' => '9876543210',
            'company_name' => 'ABC Company',
            'address' => '#123 main street',
        ]);

        $response = $this->actingAs($user)->get('/admin/leads');
        $response->assertStatus(200);
    }

    public function test_lead_delete()
    {
        $user = User::factory()->create();
        $this->prepareData();

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
            ]
        ]);

        $this->post('/api/V1/new-lead', [
            'package_id' => 1,
            'name' => 'Sam',
            'email' => 'test@gmail.com',
            'phone' => '9876543210',
            'company_name' => 'ABC Company',
            'address' => '#123 main street',
        ]);

        $this->post('/api/V1/new-lead', [
            'package_id' => 1,
            'name' => 'Sam',
            'email' => 'test@gmail.com',
            'phone' => '9876543210',
            'company_name' => 'ABC Company',
            'address' => '#123 main street',
        ]);

        $this->post('/api/V1/new-lead', [
            'package_id' => 1,
            'name' => 'Sam',
            'email' => 'test@gmail.com',
            'phone' => '9876543210',
            'company_name' => 'ABC Company',
            'address' => '#123 main street',
        ]);
        $lead_id = 1;

        $response = $this->actingAs($user)->delete('/admin/leads/'. $lead_id);
        $this->assertEquals($response->baseResponse->original['success'], true);
    }
}
