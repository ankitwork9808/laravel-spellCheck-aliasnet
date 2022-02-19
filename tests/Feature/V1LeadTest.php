<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V1LeadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_new_lead_with_all_data
     *
     * @return void
     */
    public function test_new_lead_with_all_data()
    {
        $this->prepareData();
        User::factory()->create();

        Package::insert([
            [
                'name' => '1st level',
                'employees' => '15 mitareiter',
                'amount' => 15,
                'time_period' => 'Monthly',
                'currency_symbol' => '€',
                'currency_name' => 'Euro',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/new-lead', [
            'package_id' => 1,
            'name' => 'Sam',
            'email' => 'sam@unknown.com',
            'phone' => '9876543210',
            'company_name' => 'ABC Company',
            'address' => '#123 main street',
        ]);

        $this->assertEquals(
            $response->baseResponse->original['success'],
            true
        );
    }

    /**
     * test_new_lead_with_missing_data
     *
     * @return void
     */
    public function test_new_lead_with_missing_data()
    {
        $this->prepareData();
        User::factory()->create();

        Package::insert([
            [
                'name' => '1st level',
                'employees' => '15 mitareiter',
                'amount' => 15,
                'time_period' => 'Monthly',
                'currency_symbol' => '€',
                'currency_name' => 'Euro',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/new-lead', [
            'package_id' => 1,
            'name' => 'Sam',
            'email' => '',
            'phone' => '9876543210',
            'company_name' => 'ABC Company',
            'address' => '#123 main street',
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }
}
